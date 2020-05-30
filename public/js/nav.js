function dropDown(element){
  element.classList.toggle('actives');
  var panel = element.nextElementSibling;
  if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
  } else {
      panel.style.maxHeight = panel.scrollHeight + 'px';
  } 
                          
}