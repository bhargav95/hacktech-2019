<?php
    
    $site="http://gateway.marvel.com/v1/public/characters/1009189/comics";
    $site2="http://gateway.marvel.com/v1/public/characters";
    $public_key="";
    $private_key="";

    $time_stamp="12";

    $hash="c8abca43b7fdefb0a37974a45fd17d6a";

    $res = file_get_contents($site."?orderBy=-focDate&ts=12&apikey=".$public_key."&hash=".$hash);


    $res2 = file_get_contents($site2."?nameStartsWith=black&ts=12&apikey=".$public_key."&hash=".$hash);
    
    
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="layout.css">
        <style>
            
            body{
                background-color: #ef3131;
            }
            
            h3{
                color: white;
                font-family: sans-serif;
            }
            
            #chatwindow{
                height: 500px;
                width: 950px;
                vertical-align: bottom;
                overflow-y: scroll;
                display: table-cell;
                background-color: white;
            }
            
            #wrappedScroll{
                display: block;
                overflow-y: auto;
                height: 500px;
                width = 950px;
            }
            
            
            .query{
                width: 950px;
                text-align: right;
            }
            
            .query p{
                display: inline-block;
                margin-left: auto;
                
                background-color: skyblue;
                padding: 10px;
                border-radius: 10px 10px 0px 10px;
            }
            
            
            .answer p{
                display: inline-block;
                
                background-color: #eee;
                padding: 10px;
                border-radius: 10px 10px 10px 0px;
            }
            
            .query, .answer{
                padding-left: 30px;
                padding-right: 30px;
            }
            
            
            #mainwindow{
                margin: 0 auto;
                width: 950px;
            }
            
            table td{
                color: black;
            }
            
            table td:hover{
                background-color: darkred;
                color: white;
            }
            
            #ress{
                width: 100%;
                overflow-x:hidden;
            }
            
            /* The Modal (background) */
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                padding-top: 100px; /* Location of the box */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content */
            .modal-content {
                background-color: #fefefe;
                margin: auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
            }

            /* The Close Button */
            .close {
                color: #aaaaaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }
           
            
        </style>
        
        
        
        <script>
            
            function gotochat(){
                document.getElementById("charselect").style.display="none";
                document.getElementById("mainwindow").style.display="block";
            }
            
            function showallchars(){
                
                var allchars = <?php echo $res2; ?>;
                allchars= allchars.data.results;
                
                var tab2='<h3>Select a character</h3><table class="table" border=1><tr>';
                
                for(var i=0;i<allchars.length;++i){
                    
                    if(allchars[i].thumbnail.path!='http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available'){
                        
                        tab2+='<td onclick="gotochat()"><img width=200 src="'+allchars[i].thumbnail.path+'.'+allchars[i].thumbnail.extension+'">';
                        tab2+='<br>'+allchars[i].name;    
                    }
                }
            
                document.getElementById("charselect").innerHTML=tab2;    
                document.getElementById("charselect").style.overflowX="scroll";   
            }
            
            function getres(){
                var t= <?php echo $res; ?> ;
                
                t=t.data.results;
                
                tab='<table class="table" border=0><tr>';
                
                for(var i=0;i<t.length;++i){
                    
                    tab+='<td><img width=200 src="'+t[i].thumbnail.path+'.'+t[i].thumbnail.extension+'">';
                    tab+='<br>'+t[i].title;
                    
                }
                
                
                console.log(t);
                                
                document.getElementById("ress").innerHTML=tab;    
                document.getElementById("ress").style.overflowX="scroll";
            }
            
             function getres1(){
                 
                
                var t= <?php echo $res; ?> ;
                //alert(ele.target);
                t=t.data.results;
                //ele.div.style.display='block';
                tab='<table class="table" border=0><tr>';
                
                for(var i=0;i<t.length;++i){
                    
                    tab+='<td><img width=200 src="'+t[i].thumbnail.path+'.'+t[i].thumbnail.extension+'">';
                    tab+='<br>'+t[i].title+'</td>';
                    
                }
                
                tab+='</table>';
                
                console.log(tab);
                                
                document.getElementById('hidden-div').innerHTML=tab;    
                document.getElementById('hidden-div').style.display='block';
                
                document.getElementById('hidden-div').style.overflowX="scroll";
            }
            
            function loader(){
                
                document.getElementById('chat').onkeydown = function(event) {
                    if (event.keyCode == 13) {
                        reply();
                        
                        document.getElementById('chat').value="";
                    }
                }
                
                //showallchars();
            }
            
            function reply(query=document.getElementById("chat").value){
                microsoft="https://westus.api.cognitive.microsoft.com/luis/v2.0/apps/79df3317-b46d-4ab6-9ae2-4448c73abab8?subscription-key=47f227a5156145c0ab9c8b44e5600969&verbose=true&timezoneOffset=0&q=";
                
                console.log(query);
                
                if(!query){
                    alert("Enter a Message");
                    return;
                }
                
                
                var chat=document.getElementById("chatwindow");
                
                chat.innerHTML += '<div class="query"><p>'+query+'</p></div>';
                
                
                var api = microsoft + encodeURIComponent(query);
                
                var oReq = new XMLHttpRequest();
                oReq.open("GET", api,false);
                oReq.send();
                
                var answer=oReq.responseText;
                
                var topIntent=JSON.parse(oReq.responseText).topScoringIntent.intent;
                
                var answerfrommicrosoft = eval(topIntent+'('+answer+')');
                
                var answer=JSON.parse(oReq.responseText).topScoringIntent.intent;
                
                chat.innerHTML += '<div class="answer"><img src="images/blackWidow.jpg" style="border-radius: 50%" alt="Black Widow" height="48" width="48"><p>'+answerfrommicrosoft+'</p></div>';
                //chat.innerHTML += '<div class="answer"><span>'+answer+'</span></div>';
            
                var objDiv = document.getElementById("wrappedScroll");
                objDiv.scrollTop = objDiv.scrollHeight;
            }
            
            function GiveJoke(ans=""){
                
                items=['What is a superhero\'s favorite part of the joke? The "punch" line!','Where\'s Spiderman\'s home page? On the world wide web.','What is Thor\'s favorite food? Thor-tillas','What did Bruce Banner say to Spider Man? "Don\'t bug me."','What is it called when Iron Man does a cart wheel? A Ferrous Wheel!']
                
                res="Here's a joke: "+items[Math.floor(Math.random()*items.length)];
                
                res+='<br><input type="button" name="another_joke" value="Another Joke" onclick=\'reply("joke")\'>';
                
                return res;
            }
            
            function Bully(ans){
                return "That's terrible, I'm sorry. My advice is to not confront the bully. Talk to your parents/guardians or a school supervisor.";
            }
            
            function Addition(ans){
                return "The answer is&nbsp;"+((+ans.entities[0].entity)+(+ans.entities[1].entity));
            }
            
            function AreYouFriendsWith(ans){
                
                friend=ans.entities[0].entity;
                
                if(friend=="Hulk"){
                    return "Yes! I'm friends with the Hulk";    
                }
                else{
                    return "";
                }
                
                
            }
            
            function createComics(ele)
            {
                document.getElementById('myModal').style.display='block';
                //ele.style.display='block';
                getres1()
            }
            function GetComics(ans){
                
                
                //getres();   
                return '<button id="myBtn" onclick="createComics(this)"style="display:blockfmy;">Click here</button>&nbsp;to see some of the Marvel comics I appear in!';
            }
            
            function Greeting(ans){
                return "Hey there! What is your name?";
            }
            
            function GetName(ans){
                name = ans.entities[0].entity
                return "Hello "+ name[0].toUpperCase() + name.substr(1) +"!";
            }
            
            function clearchat(){
                document.getElementById("chatwindow").innerHTML="";
            }
            
            function RealName(ans){
                return "My real name is Natasha Romanoff";
            }
            
            
            
        </script>
    </head>
    <body onload="loader()">
        
        
        <div style="margin:0 auto; text-align:center">
        
            <img src="https://i.imgur.com/ZIYrlmG.png" width="1000">


            <div id="charselect">
                </div>
        </div>
        
        <div id="mainwindow" style="display:block">
            
            
            
            <!-- The Modal -->
            <div id="myModal" class="modal">
                
              <!-- Modal content -->
              <div class="modal-content" >
                <span class="close">&times;</span>
                <p>Here are the comics that I appear in: </p>
                    <div id='hidden-div' style='display:none;'></div>
                </div>
                
            </div>
            
            <script>
            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal 
            //btn.addEventListener("click", getres1);
                
             
            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
            </script>


            <h3>
                <p style="text-align:left;font-family: 'Permanent Marker', cursive;">
                    Chat with Black Widow!
                    <span style="float:right;">
                        <input style="text-align:right" type="button" class="btn btn-secondary" name="clear" id="clear" value="Clear Chat" onclick="clearchat()">
                    </span>
                </p>
            </h3>

            <div id="wrappedScroll">
            <div id="chatwindow">

            </div>
            </div>
            
            
            <div class="input-group" style="padding-top:5px">
                <input class="form-control" type="text" name="chat" id="chat" placeholder="Type your message here!">

                <input type="button" class="btn btn-secondary" name="send" id="send" value=">" onclick="reply()">
                
            </div>    

        </div>
        
        
        <div id="ress"></div>
    </body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
</html>
