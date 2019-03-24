(function () {
    angular.module("stvCounter", [])
        .service("stvCounter", function () {
            var srvc = this;

            /** All ballots to be used */
            srvc.ballots = [];
            /** Rounds recorded, in order. */
            srvc.rounds = [];
            /** Quota Calculated */
            srvc.quota = 0;

            /**
             * Counts the votes and returns elected candidates.
             * @param {number} seats - Number of seats to fill.
             * @param {string[][]} [ballots] - Ballots to be counted.
             * @returns {string[]} Elected candidates.
             */
            srvc.count = function (seats, ballots = srvc.ballots) {
                srvc.ballots = ballots;
                srvc.rounds = [];

                // Construct work ballots, which are ballots array with more properties
                var workBallots = [];
                ballots.forEach(function (ballot) {
                    var workBallot = {
                        ballot: ballot,
                        topCandidate: ballot[0],
                        topCandidateIndex: 0,
                        voteValue: 1
                    };
                    workBallots.push(workBallot);
                });

                // Droop method
                srvc.quota = Math.floor(ballots.length / (seats + 1) + 1);

                var candidates = getCandidates(ballots);
                var elected = [];

                // Quick checks before counting
                if (seats <= 0 || seats > candidates.length) {
                    throw new Error("Insufficient number of seats (" + seats + ") for number of voted candidates (" + candidates.length + ")");
                }

                // Loop through ballots' first choice
                var firstRound = genBlankRound(candidates);
                ballots.forEach(function (ballot) {
                    // Tally up first choice votes
                    firstRound[ballot[0]].votes++;
                });

                // Determine elected from first round
                candidates.some(function (candidate) {
                    // If at or above quota, add to elected.
                    if (firstRound[candidate].votes >= srvc.quota) {
                        elected.push(candidate);
                        firstRound[candidate].elected = true;
                    }
                    // If all seats are filled, break.
                    if (elected.length >= seats)
                        return true;
                });
                srvc.rounds.push(firstRound);

                // Quick check before going into the real meat
                if (elected.length >= seats)
                    return elected;

                // Continue looping until we fill all seats.
                while (elected.length < seats) {
                    var round = cloneLastRound();

                    // First, check if we have enough votes
                    if (!haveEnoughVotesToMeetQuota(round)) {
                        // Votes cannot be reassigned any more to produce significant results.
                        // Return top [#seats] candidates.
                        elected = topCandidates(round, seats);
                        srvc.rounds.push(round);
                        return elected;
                    }

                    // Check for surplus
                    var hasSurplus = false;
                    Object.keys(round).some(function (candidate) {
                        if (round[candidate].votes >= srvc.quota) {
                            round[candidate].elected = true;
                            if (round[candidate].votes > srvc.quota) {
                                hasSurplus = true;
                            }
                        }
                        return hasSurplus;
                    });
                    // Reassign votes, based on surplus or elimination.
                    if (hasSurplus) {
                        reassignSurplusVotes(round, workBallots);
                    }
                    else { // Elimination
                        eliminateCandidates(round);
                        reassignEliminatedVotes(round, workBallots);
                        if (checkTie(round, seats)) {
                            return elected;
                        }
                    }

                    // And another check to see if anybody made it
                    Object.keys(round).some(function (candidate) {
                        if (round[candidate].elected || round[candidate].votes >= srvc.quota) {
                            round[candidate].elected = true;
                            if (elected.indexOf(candidate) < 0) elected.push(candidate)
                        }
                        if (elected.length >= seats)
                            return true;
                    })

                    // Check for duplicate round
                    if (JSON.stringify(round) === JSON.stringify(cloneLastRound())) {
                        break;
                    }

                    // Finally, record round
                    srvc.rounds.push(round);
                }

                return elected;
            }

            /**
             * Gets all possible candidates from srvc.ballots.
             * @returns {string[]} list of candidates.
             */
            function getCandidates() {
                var candidates = [];
                srvc.ballots.forEach(function (ballot) {
                    ballot.forEach(function (candidate) {
                        if (candidates.indexOf(candidate) < 0) {
                            candidates.push(candidate);
                        }
                    })
                })
                return candidates;
            }

            /**
             * Generates a blank round based on [candidates], defaulting all properties to primitive 0 (boolean -> false).
             * @param {string[]} candidates - list of candidates to generate round for.
             * @returns {Object.<string, {votes: number, elected: boolean, eliminated: boolean}>} a blank round.
             */
            function genBlankRound(candidates) {
                var round = {};
                candidates.forEach(function (candidate) {
                    round[candidate] = { votes: 0, elected: false, eliminated: false };
                })
                return round;
            }

            /**
             * Clones the most recent round using JSON.stringify hack.
             * @returns {Object.<string, {votes: number, elected: boolean, eliminated: boolean}>} most recent round as a new cloned object.
             */
            function cloneLastRound() {
                if (srvc.rounds.length == 0) return {};
                return JSON.parse(JSON.stringify(srvc.rounds[srvc.rounds.length - 1]));
            }

            /**
             * Goes through the round and marks all candidates with the lowest votes as eliminated.
             * @param {Object.<string, {votes: number, elected: boolean, eliminated: boolean}>} round - STV round to analyze and change.
             */
            function eliminateCandidates(round) {
                var leastNumberOfVotes = getLeastNumberOfVotes(round);
                Object.keys(round).forEach(function (candidate) {
                    if (round[candidate].votes == leastNumberOfVotes) {
                        round[candidate].eliminated = true;
                    }
                });
            }

            /**
             * Checks if there is a case of there are too few candidates to fill all seats, in which case would be a tie.
             * @param {Object.<string, {votes: number, elected: boolean, eliminated: boolean}>} round - STV round to analyze.
             * @param {number} numberOfSeats - number of seats that need to be filled.
             * @returns {boolean} true if there is a tie.
             */
            function checkTie(round, numberOfSeats) {
                var validCandidates = 0;
                Object.keys(round).forEach(function (candidate) {
                    if (!round[candidate].eliminated) {
                        validCandidates++;
                    }
                });
                return validCandidates < numberOfSeats;
            }

            /**
             * Figures out the least number of votes in the [round]
             * @param {Object.<string, {votes: number, elected: boolean, eliminated: boolean}>} round - STV round to analyze and change.
             * @returns {number} least number of votes.
             */
            function getLeastNumberOfVotes(round) {
                var least = 0;
                var foundStartingValue = false;
                Object.keys(round).forEach(function (candidate) {
                    if (!foundStartingValue && !round[candidate].eliminated) {
                        foundStartingValue = true;
                        least = round[candidate].votes;
                    }
                    if (!round[candidate].eliminated && round[candidate].votes < least && foundStartingValue) {
                        least = round[candidate].votes;
                    }
                });
                return least;
            }

            /**
             * Reassigns all eliminated votes based on eliminated candidates in the round.
             * @param {Object.<string, {votes: number, elected: boolean, eliminated: boolean}>} round - STV round to analyze and change.
             * @param {Object[]} workBallots - enhanced ballot objects to work with.
             * @param {string[]} workBallots[].ballot - list of candidates in preferred order.
             * @param {string} workBallots[].topCandidate - current top candidate on the work ballot.
             * @param {number} workBallots[].topCandidateIndex - index of the top candidate in [workBallot.ballot].
             * @param {number} workBallots[].voteValue - current value of the ballot's vote, if <1, then other part is assigned to elected candidates elsewhere on ballot.
             */
            function reassignEliminatedVotes(round, workBallots) {
                Object.keys(round).forEach(function (candidate) {
                    if (round[candidate].eliminated) {
                        round[candidate].votes = 0;
                        workBallots.forEach(function (workBallot) {
                            if (candidate === workBallot.topCandidate) {
                                reassignVote(workBallot, round);
                            }
                        });
                    }
                });
            }

            /**
             * Reassigns all surplus votes based on elected candidates in the round.
             * @param {Object.<string, {votes: number, elected: boolean, eliminated: boolean}>} round - STV round to analyze and change.
             * @param {Object[]} workBallots - enhanced ballot objects to work with.
             * @param {string[]} workBallots[].ballot - list of candidates in preferred order.
             * @param {string} workBallots[].topCandidate - current top candidate on the work ballot.
             * @param {number} workBallots[].topCandidateIndex - index of the top candidate in [workBallot.ballot].
             * @param {number} workBallots[].voteValue - current value of the ballot's vote, if <1, then other part is assigned to elected candidates elsewhere on ballot.
             */
            function reassignSurplusVotes(round, workBallots) {
                Object.keys(round).forEach(function (candidate) {
                    if (round[candidate].elected && round[candidate].votes >= srvc.quota) {
                        var voteValue = (round[candidate].votes - srvc.quota) / round[candidate].votes;
                        round[candidate].votes = srvc.quota;
                        workBallots.forEach(function (workBallot) {
                            if (candidate === workBallot.topCandidate) {
                                workBallot.voteValue = voteValue * workBallot.voteValue;
                                reassignVote(workBallot, round);
                            }
                        })
                    }
                });
            }

            /**
             * Reassigns vote to next top candidate on [workBallot].
             * @param {Object} workBallot - enhanced ballot object to work with.
             * @param {string[]} workBallot.ballot - list of candidates in preferred order.
             * @param {string} workBallot.topCandidate - current top candidate on the work ballot.
             * @param {number} workBallot.topCandidateIndex - index of the top candidate in [workBallot.ballot].
             * @param {number} workBallot.voteValue - current value of the ballot's vote, if <1, then other part is assigned to elected candidates elsewhere on ballot.
             * @param {Object.<string, {votes: number, elected: boolean, eliminated: boolean}>} round - STV round to analyze
             */
            function reassignVote(workBallot, round) {
                if (workBallot.topCandidateIndex + 1 == workBallot.ballot.length) return;

                for (; workBallot.topCandidateIndex < workBallot.ballot.length; workBallot.topCandidateIndex++) {
                    workBallot.topCandidate = workBallot.ballot[workBallot.topCandidateIndex];
                    if (!round[workBallot.topCandidate].eliminated &&
                        !round[workBallot.topCandidate].elected) {
                        round[workBallot.topCandidate].votes += workBallot.voteValue;
                        break;
                    }
                }
            }

            /**
             * Checks if there are enough free votes in the round to be reassigned for a candidate to meet quota.
             * @param {Object.<string, {votes: number, elected: boolean, eliminated: boolean}>} round - STV round to analyze
             * @returns {boolean} true if there are enough votes to meet quota.
             */
            function haveEnoughVotesToMeetQuota(round) {
                var votes = 0;
                Object.keys(round).forEach(function (candidate) {
                    if (round[candidate].votes > srvc.quota) {
                        votes += round[candidate].votes - srvc.quota;
                    }
                    else if (!round[candidate].elected) {
                        votes += round[candidate].votes;
                    }
                });
                return votes >= srvc.quota;
            }

            /**
             * Finds the top [seats] candidates based on votes.
             * @param {Object.<string, {votes: number, elected: boolean, eliminated: boolean}>} round - STV round to analyze
             * @param {number} seats - number of seats to fill in this election.
             * @returns {string[]} Top [seats] candidates, sorted by votes.
             */
            function topCandidates(round, seats) {

                // Convert round to list
                var list = [];
                Object.keys(round).forEach(function (candidate) {
                    list.push({ candidate: candidate, votes: round[candidate].votes });
                });

                // sort ...
                var sortedList = list.sort(roundCompare);

                // ... and fill in up to [seats]
                var elected = [];
                for (var i = 0; i < seats && i < sortedList.length; i++) {
                    round[sortedList[i].candidate].elected = true;
                    elected.push(sortedList[i].candidate);
                }

                return elected;
            }

            /**
             * Comparison function for candidate votes.
             * @param {number} CandidateA.votes
             * @param {number} CandidateB.votes
             * @returns {number} Standard sorting difference for greatest to least.
             */
            function roundCompare(candidateA, candidateB) {
                return candidateB.votes - candidateA.votes;
            }

        })
})()