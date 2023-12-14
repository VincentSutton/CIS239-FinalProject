var quoteArray = [];
var authVal = "";

window.addEventListener("load", function () {
  httprequest = new XMLHttpRequest();
  httprequest.open("get", "../API/endpoint.php?key=aa2e4d3c68cb21c0"); // Change this to add the key you got from Step 1
  httprequest.send();
  httprequest.onreadystatechange = getQuotes;
});

function getQuotes() {
  if (httprequest.readyState == 4 && httprequest.status == 200) {
    var quoteResponse = httprequest.responseText;
    quoteObj = JSON.parse(quoteResponse);
    console.log(quoteObj);
    for (i = 0; i < quoteObj.data.length; i++) {
      quoteArray.push(quoteObj.data[i]);
    }
    console.log(quoteArray);
  }
}

document.getElementById("quoteButton").addEventListener("click", function () {
  var chosenQuote = Math.floor(Math.random() * quoteArray.length);
  document.getElementById("quoteText").innerHTML =
    quoteArray[chosenQuote].quoteText;
  document.getElementById("quoteAuthor").innerHTML =
    quoteArray[chosenQuote].quoteAuthor;
});

document.getElementById("authorSelect").addEventListener("submit", fetchAuthor);
function fetchAuthor(e) {
  var frm = e.target;
  authVal = frm.author.value;
  httprequest = new XMLHttpRequest();
  httprequest.open(
    "get",
    `../API/endpoint.php?key=aa2e4d3c68cb21c0&author=${encodeURIComponent(
      authVal
    )}` // Change this to add the key you got from Step 1
  );
  httprequest.send();
  httprequest.onreadystatechange = setQuote;
  e.preventDefault();
}
function setQuote() {
  var aryQuotes = [];
  if (httprequest.readyState == 4 && httprequest.status == 200) {
    var quoteResponse = httprequest.responseText;
    quoteObj = JSON.parse(quoteResponse);
    console.log(quoteObj);
    for (i = 0; i < quoteObj.data.length; i++) {
      aryQuotes.push(quoteObj.data[i].quoteText);
    }
  }
  document.getElementById("quoteAuthor").innerHTML = authVal;
}
