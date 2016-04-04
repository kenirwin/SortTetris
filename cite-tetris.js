

var game = {
    init: function () {
//        alert ('test: init');
        var i;
data = [
    { 
        "citation": "<em>ATQ</em>. Jun98, Vol. 12 Issue 2, p145.",
        "type" : "article"
    },
    { 
        "citation": "Burke, Susan L., et al. ''Letters.'' <em>Ms</em> 22.1 (2012): 6-8.", 
        "type" : "article"
    },
    { 
        "citation": "<em>Albert H. University of Chicago Law Review</em>. Spring2008, Vol. 75 Issue 2, p649-714.",
        "type": "article"
    },
    {
        "citation": "<em>The New Woman in Fiction and in Fact: Fin-de-Siecle Feminisms</em>. New York, NY: Palgrave, 2001.", 
        "type": "book"
    },
    {
        "citation": 'BRENNAN, PATRICK H. 2006. "Journalism." <em>Oxford Companion To Canadian History</em> 332-333.',
        "type": "book chapter"
    },
    {
        "citation": "<cite>Women of Minnesota : selected biographical essays. St. Paul : Minnesota Historical Society Press</cite>, 1977", 
        "type": "book"
    },
{"citation":"Bridges, L., Rempel, H., &amp; Griggs, K. (2010). Making the case for a fully mobile library web site: from floor maps to the catalog. <em>Reference Services Review</em>, 38, 309-320.","type":"article"},{"citation":"Day, Mike, and Don Revill. 1995. Towards the active collection: The use of circulation analyses in collection evaluation. <em>Journal of Librarianship and Information Science</em> 27 (September): 149-157.","type":"article"},{"citation":"Doucet, J. (1999), <em>My Most Secret Desire</em>, Drawn &amp; Quarterly, Montreal.","type":"book"},{"citation":"Doxiadis, A. and Papadimitriou, C.H. (2009), <em>Logicomix: An Epic Search for Truth</em>, Bloomsbury USA, New York.","type":"book"},{"citation":"Evans, G. Edward. 2000. <em>Developing library and information center collections</em>. 4th ed. Englewood, CO: Libraries Unlimited.","type":"book"},{"citation":"Fling, Brian. (2009) <em>Mobile Design and Development</em>. Sebastopol, CA: O'Reilly","type":"book"},{"citation":"Gordon, I. (2010), &ldquo;Making Comics Respectable: How Maus Helped Redefine a Medium&rdquo;, <em>The Rise of the American Comics Artist: Creators and Contexts</em>, University of Mississippi Press, Jackson, pp. 160.167.","type":"book chapter"},{"citation":"Gruber, J. (2011a), &ldquo;The Impacts Of The Affordable Care Act: How Reasonable Are The Projections the Impacts Of The Affordable Care Act: How Reasonable Are The Projections?&rdquo;, <em>National Tax Journal</em>, Vol. 64 No. 3, pp. 893-908.","type":"article"},{"citation":"Haefele, C. (2011). One Block at a Time: Building a Mobile Site Step by Step. <em>Reference Librarian</em>, 52, 117-127.","type":"article"},{"citation":"Loman, A. (2010), &ldquo;.That Mouse.s Shadow.: The Canonization of Maus&rdquo;, in Williams, P. and Lyons, J. (Eds.), <em>The Rise of the American Comics Artist</em>, University Press of Mississippi, Jackson.","type":"book chapter"},{"citation":"Mack, S. (2012), <em>Taxes, the Tea Party, and Those Revolting Rebels: A History in Comics of the American Revolution</em>, NBM Publishing, New York.","type":"book"},{"citation":"National Commission on Terrorist Attacks. (2004), The 9/11 Commission Report: Final Report of the National Commission on Terrorist Attacks Upon the United States, W. W. Norton &amp; Company, New York.","type":"book"},{"citation":"Neufeld, J. (2010), <em>A.D.: New Orleans After the Deluge</em>, Pantheon, New York.","type":"book"},{"citation":"Oppegaard, B. (2012), &ldquo;A Review of .The Influencing Machine: Brooke Gladstone on the Media..&rdquo;, <em>Visual Communication Quarterly</em>, Vol. 19 No. 3, pp. 191.193.","type":"article"},{"citation":"Peasgood, Adrian N. 1986. Towards demand-led book acquisitions? Experiences in the University of Sussex Library. <em>Journal of Librarianship</em> 18 (October): 242-256.","type":"article"},{"citation":"Rader, P.J. (2012), &ldquo;Readings and Rebellions in Persepolis and Persepolis 2&rdquo;, in Jakaitis, J. and Wurtz, J.F. (Eds.),<em>Crossing Boundaries in Graphic Narrative: Essays on Forms, Series and Genres</em>, McFarland, Jefferson, N.C., pp. 123.137.","type":"book chapter"},{"citation":"Ragon, B. (2009). Designing for the Mobile Web. <em>Journal of Electronic Resources in Medical Libraries</em>, 6, 355-361. doi:10.1080/15424060903364875","type":"article"},{"citation":"Schack, T. (2014), &ldquo;.A failure of language.: Achieving layers of meaning in graphic journalism.&rdquo;, <em>Journalism</em>, Vol. 15 No. 1, pp. 109.127.","type":"article"},{"citation":"Smith, S.D. &amp; Caruso J.B. (2009). <em>ECAR Study of Undergraduate Students and Information Technology</em>, Boulder, CO: EDUCAUSE Center for Applied Research. ","type":"book"},{"citation":"Whitlock, G. (2007), <em>Soft weapons?: autobiography in transit</em>, Chicago: University of Chicago Press, 2007.","type":"book"},{"citation":"Winick, J. (2000), <em>Pedro and Me: Friendship, Loss, and What I Learned</em>, Heny Holt, New York.","type":"book"},{"citation":"Wisniewski, Jeff. (2010). &quot;Mobile Websites With Minimum Effort.&quot; <em>Online</em>. Vol. 34(1), 54-57.","type":"article"},{"citation":"Witek, J. (1999), &ldquo;Ramses in the Ivory Tower&rdquo;, <em>The Comics Journal</em>, April 1999, No. 211, pp. 58.61.","type":"article"},{"citation":"Wolfe, G.K. (1994), &ldquo;On Some Recent Scholarship&rdquo;, <em>Science Fiction Studies</em>, Vol. 21 No. 3, pp. 439.440.","type":"article"}

];
        game.data = data;
        game.buttons = ['book','book chapter', 'article'];
        game.controls();
        game.rows = [];
        game.activeRow = 0;
        game.citeText = '';
        game.color = 'lightblue';
        game.blankColor = 'white';
        game.height = 12;
        game.lastClearRow = game.height;
        game.interval = 600;
        for (i=1; i<(game.height+1); i++) {
            game.rows[i] = -1; //empty
        }
        game.bound = $.browser == 'msie' ? '#game' : window;
    },


    controls: function () {
        var buttonsHTML = '';
        for (var i = 0; i < game.buttons.length; i++) {
            buttonsHTML += '<br/><button class="game-button" id="'+game.buttons[i]+'">'+game.buttons[i]+'</button><br/>';
        }

        $('#controls').html(buttonsHTML);
    },


    start: function () {
//        alert ('test: start');
//        $(game.bound).keypress(game.key); // accept keyboard input
        $('.game-button').click(function() {
            game.clickEval(this.id);
        });
        game.next();
    },
    
    next: function () {
        game.debug();
        game.nextCite = game.newCite();
        game.timer = window.setInterval(game.moveDown, game.interval);
    },

    key: function(e) {
        alert(e.charCode);
        switch(e.charCode) {
        case 97: break; //a
        case 98: break; //b
        }
        return false;
    },
    
    clickEval: function (id) {
       window.clearInterval(game.timer);
        game.debug();
        game.givenAnswer = id;
       if (game.givenAnswer === game.currAnswer) {
            game.correct();
        }
        else {
            game.incorrect();
        }
    },

    correct: function () {
         game.timer = window.setTimeout(function() { game.next() }, game.interval);
        $('#row'+game.activeRow).html('').css('background-color',game.blankColor);
        game.rows[game.activeRow] = -1;
    },

    incorrect: function () {
        // move to game.lastClearRow
        for (var j=1; j < game.lastClearRow; j++) {
            game.rows[j] = -1;
            $('#row'+j).html('').css('background-color',game.blankColor);
        }
        game.debug();
        $('#row'+game.lastClearRow).html(game.citeText).css('background-color',game.color);
        game.activeRow = game.lastClearRow;
        game.rows[game.activeRow] = 1;
        game.debug();
        game.touchdown();
        game.debug();
    },

    
    newCite: function () {
        if (game.rows[1] !== 1) {
            var citeIndex = Math.floor(Math.random()*game.data.length);
            game.citeText = game.data[citeIndex].citation;
            game.currAnswer = game.data[citeIndex].type;
            game.color = "lightblue";
            $('#row1').html(game.citeText).css('background-color',game.color);
            $('#citation').html(game.citeText).css('background-color',game.color);
            game.activeRow = 1;
            game.rows[game.activeRow] = 1;
        }
        else if (game.rows.join('').indexOf('-1') == -1) {
            game.debug();
            game.gameOver();
        }
    },

    listProperties: function(obj) {
    var list='';
    for (var propertyName in obj) {
        if (typeof obj[propertyName] == "string" || typeof obj[propertyName] == "number") {
            list += '<li>'+propertyName+': ' + obj[propertyName]+ '</li>';
        }
        else { 
            list += '<li>'+propertyName+': ' + typeof obj[propertyName]+ '</li>';
        }

    }
    return list;

    },
    
    debug: function () {
        var listProp=game.listProperties(game);
        listProp += game.listProperties(game.rows);
        $("#debug").html(listProp);
    },

    moveDown: function () {
        game.debug();
        var n = game.activeRow;
        if (game.rows[game.activeRow+1] === -1) {
            $('#row'+game.activeRow).html('').css('background-color',game.blankColor);
            game.rows[game.activeRow] = -1;
            game.rows[game.activeRow+1] = 1; 
            game.activeRow++;
            $('#row'+game.activeRow).html(game.citeText).css('background-color',game.color);
          }  
        else {
            game.touchdown();
            return false;
        }
        },
    touchdown: function () {
        game.debug();
        game.lastClearRow = game.activeRow-1;

        $('#row'+game.activeRow).css("background-color","red").attr("data-correct",game.currAnswer).attr("data-incorrect",game.givenAnswer);
        window.clearInterval(game.timer);
        game.timer = window.setTimeout(function() { game.next() }, game.interval);
        return false;
    },

    gameOver: function () {
        game.debug();
        alert ('Game Over');
        window.clearInterval(game.timer);
        $("#grid td").css("background-color","lightgrey").each(function() {
                $(this).append( 
                    $('<span>'+$(this).attr("data-correct")+'</span>').addClass("overlay correct") 
                    .append($('<span>'+$(this).attr('data-incorrect')+'</span>').addClass("incorrect"))
                );
        });
        delete game.timer;
        $("#controls .game-button").unbind();
        die();
    },


};

$(window).load(function() {
    game.init();
    game.start();
});
