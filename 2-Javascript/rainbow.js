
var arr = ["red", "orange", "yellow", "green", "blue", "darkblue", "violet"];

function recurse(counter) {

  var color = arr[counter];

  $('#rainbow').css("color", color);

  arr.splice(counter, 1);
  arr.splice(0, 0, color);

  setTimeout(function() {
    if(typeof arr[counter + 1] === 'undefined') {
      counter = 0;
    }
    recurse(counter + 1);
  }, 1200);
};

recurse(0);