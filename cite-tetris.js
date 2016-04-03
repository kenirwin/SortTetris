var game = {
    init: function () {
//        alert ('test: init');
        var i;
        game.rows = [];
        
        for (i=1; i<13; i++) {
            game.rows[i] = 0; //empty
        }
        game.bound = $.browser == 'msie' ? '#game' : window;
    },

    start: function () {
//        alert ('test: start');
        $(game.bound).keypress(game.key);
        game.next = game.newCite();
        game.delay=100;
        game.timer = window.setInterval(game.moveDown, game.delay);
    },


    key: function(e) {
        alert(e.charCode);
        switch(e.charCode) {
        case 97: break; //a
        case 98: break; //b
        }
        return false;
    },
    
    newCite: function () {
        citeText = "Test Citation";
        color = "lightblue";
        $('#row1').text(citeText).css('background-color',color);
        game.activeRow = 1;
        game.rows[game.activeRow] = 1;
    },

    moveDown: function () {
        var n = game.activeRow;
        if (game.rows[game.activeRow+1] === 0) {
            game.rows[game.activeRow] = 0;
            game.rows[game.activeRow+1] = 1; 
            game.activeRow++;
          }  
        },
};

$(window).load(function() {
    game.init();
    game.start();
});
