window.addEventListener('load', function () {

    // auto remove alert after 7sec
    setTimeout(function () {
        let alertContainer = $('.alert');

        if (alertContainer.is(':visible')) {
            alertContainer.fadeOut();
        }
    }, 7000)

    // security token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#fight').focus();

    // analise fight
    $('#fight').click(function (e) {
        e.preventDefault();
        let heroAttr              = $('#hero-attributes');
        let beastAttr             = $('#beast-attributes');
        let battleStats           = $('#battle-stats');
        let battleStatisticsTable = $('#battle-statistics');
        let turnSide              = $('#turn-side');
        let currentTurn           = $('#current-turn > small');
        let btnFightObj           = $('#fight');
        let initialText           = btnFightObj.html();
        let maxTurns              = battleStats.data('maxturns');
        let statisticsTurn        = 0;
        //set data
        let dataFight             = {
            turn: battleStats.data('turn'),
            hero: getPlayerData(heroAttr),
            beast: getPlayerData(beastAttr)
        };

        btnFightObj.html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>' + initialText).addClass('disabled');

        $.ajax({
            type: "POST",
            url: '/home/analise',
            data: dataFight,
            success: function (data) {
                let fightResults = $.parseJSON(data);
                btnFightObj.html(initialText).removeClass('disabled');
                if ($.isEmptyObject(data.error)) {
                    // increase the turn
                    let newTurn = fightResults.turn + 1;
                    if (fightResults.winner) {
                        btnFightObj.hide()
                        $('#new-battle').show().focus();
                        $('#center-info').hide();
                        if (fightResults.winner === 'hero') {
                            $('#beast-dead').show();
                        } else {
                            $('#hero-dead').show();
                        }
                    } else {
                        currentTurn.html('turn<br />' + newTurn);
                        battleStats.data('turn', newTurn);
                        setTimeout(function () {
                            btnFightObj.click();
                        }, 500)
                    }

                    // show battle statistics
                    battleStatisticsTable.show();
                    let newRowContent = '<tr>' +
                        '<td>' + fightResults.turn + '</td>' +
                        '<td>' + (fightResults.stats.attacker) + '</td>' +
                        '<td>' + (fightResults.stats.defender_luck) + '</td>' +
                        '<td>' + (fightResults.stats.damage) + '</td>' +
                        '<td>' + (fightResults.stats.defender_health) + '</td>' +
                        '<td>' + (fightResults.stats.hero_skill) + '</td>' +
                        '<td>' + (fightResults.stats.winner) + '</td>' +
                        '</tr>';
                    battleStatisticsTable.find('tbody').append(newRowContent);

                    // set frontend values
                    let playersResultsArray = {
                        'hero': {
                            'domObj': heroAttr,
                            'action': fightResults.hero.action,
                            'luck': fightResults.hero.luck,
                            'health': fightResults.hero.health
                        },
                        'beast': {
                            'domObj': beastAttr,
                            'action': fightResults.beast.action,
                            'luck': fightResults.beast.luck,
                            'health': fightResults.beast.health
                        }
                    };

                    $('div[id$=-card]').removeClass(function (index, className) {
                        return (className.match(/(^|\s)border-\S+/g) || []).join(' ');
                    });

                    for (let key in playersResultsArray) {
                        setPlayerData(key, playersResultsArray[key]['domObj'], playersResultsArray[key]['action']);
                        showPlayerLuck(key, playersResultsArray[key]['luck']);
                        updatePlayerHealth(key, playersResultsArray[key]['health']);
                    }
                }
            }
        });
    });

    function getPlayerData(playerDomObj) {
        return {
            name: playerDomObj.data('player'),
            action: playerDomObj.data('action'),
            health: playerDomObj.find('tr[data-name="health"]').data('value'),
            strength: playerDomObj.find('tr[data-name="strength"]').data('value'),
            defence: playerDomObj.find('tr[data-name="defence"]').data('value'),
            speed: playerDomObj.find('tr[data-name="speed"]').data('value'),
            luck: playerDomObj.find('tr[data-name="luck"]').data('value')
        };
    }

    function setPlayerData(playerName, playerDomObj, playerReturnValue) {
        let playerCard        = $('#' + playerName + '-card');
        let playerFightStatus = $('#' + playerName + '-fight-status');
        let turnSide          = $('#turn-side');
        playerDomObj.data('action', playerReturnValue);

        switch (playerReturnValue) {
            case 0:
                playerCard.addClass('border-danger');
                playerFightStatus.html('defender');
                if (playerName === 'hero') {
                    turnSide.html('&#129092;');
                }
                break;
            case 1:
                playerCard.addClass('border-success');
                playerFightStatus.html('attacker');
                if (playerName === 'hero') {
                    turnSide.html('&#129094;');
                }
                break;
        }
    }

    function showPlayerLuck(playerName, playerReturnValue) {
        let playerDomObj = $('#' + playerName + '-luck');
        if (playerReturnValue === 1) {
            playerDomObj.show();
        } else {
            playerDomObj.hide();
        }
    }

    function updatePlayerHealth(playerName, playerReturnValue) {
        let playerHealth         = $('#' + playerName + '-attributes tbody tr[data-name="health"]');
        let playerHealthProgress = $('#' + playerName + '-attributes div.progress-bar');
        if (playerReturnValue >= 0) {
            playerHealth.data('value', playerReturnValue);
            playerHealth.find('.attr-value').html(playerReturnValue);
            playerHealthProgress.attr('style', 'width: ' + playerReturnValue + '%;')
                .attr('aria-valuenow', playerReturnValue);
            playerHealthProgress.removeClass(function (index, className) {
                return (className.match(/(^|\s)bg-\S+/g) || []).join(' ');
            });
            if (playerReturnValue > 75) {
                playerHealthProgress.addClass('bg-success');
            } else if (playerReturnValue > 50 && playerReturnValue < 74) {
                playerHealthProgress.addClass('bg-info');
            } else if (playerReturnValue > 25 && playerReturnValue < 49) {
                playerHealthProgress.addClass('bg-warning');
            } else if (playerReturnValue < 24) {
                playerHealthProgress.addClass('bg-danger');
            }
        }
    }

});