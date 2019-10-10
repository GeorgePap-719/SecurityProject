// < first movement 1 and 3 moves to right and 2 and 4 moves to left>

function move13R() {
  var elem1 = document.getElementById("animate1");
  var elem3 = document.getElementById("animate3");

  var pos13=50;
  var id = setInterval(frame1, 80);

  function frame1() {
    if (pos13 == 60) {
      clearInterval(id);
      move13L();
    }
    else {
      pos13++;
      elem1.style.left = pos13 + 'px';
      elem3.style.left = pos13 + 'px';
    }
  }

}

function move24L() {
  var elem2 = document.getElementById("animate2");
  var elem4 = document.getElementById("animate4");

  var pos24=775;
  var id = setInterval(frame2, 80);

  function frame2() {

    if (pos24 == 765) {
      clearInterval(id);
      move24R();
    }
    else {
      pos24--;
      elem2.style.left = pos24 + 'px';
      elem4.style.left = pos24 + 'px';
    }
  }

}


// < first movement 1 and 3 moves to left and 2 and 4 moves to right>

function move13L() {
  var elem1 = document.getElementById("animate1");
  var elem3 = document.getElementById("animate3");


  var pos=60;
  var id = setInterval(frame2, 80);

  function frame2() {

    if (pos == 50) {
      clearInterval(id);
      move13R();
    }
    else {
      pos--;
      elem1.style.left = pos + 'px';
      elem3.style.left = pos + 'px';
    }
  }

}

function move24R() {
  var elem2 = document.getElementById("animate2");
  var elem4 = document.getElementById("animate4");


  var pos=765;
  var id = setInterval(frame1, 80);

  function frame1() {
    if (pos == 775) {
      clearInterval(id);
      move24L();
    }
    else {
      pos++;
      elem2.style.left = pos + 'px';
      elem4.style.left = pos + 'px';
    }
  }

}
