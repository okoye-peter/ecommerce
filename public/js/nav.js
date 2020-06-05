function dropDown(element){
  element.classList.toggle('actives');
  var panel = element.nextElementSibling;
  if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
  } else {
      panel.style.maxHeight = panel.scrollHeight + 'px';
  } 
                          
}

function sidebarTooggle(){
  let sidebar = document.getElementById("sidebar");
  sidebar.getElementsByClassName('closebtn')[0].style.display = 'inline-block';
  sidebar.style.width =  "13em";
  return false;
}

function closeNav(btn){
  btn.parentNode.style.width = '0px';
  btn.style.display ='none';
}