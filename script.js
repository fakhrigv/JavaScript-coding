setTimeout(function(){
  var d, rezultat;
  document.getElementsByClassName("button")[0].onclick = end;
  document.getElementsByClassName("input")[0].onclick = start;


  function start(){
    d = performance.now();
  };
  function end(){
    rezultat = performance.now() - d;
    alert(rezultat/1000)
  }
},1000);