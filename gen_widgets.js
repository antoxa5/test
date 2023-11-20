//var image = document.getElementById("etorazvod-widget_image");
//image.src += "?nocache=" + new Date().getTime();
//image.onclick = loadImg;
//function loadImg() {
//    window.open('https://beta2.eto-razvod.ru/review/' + image.getAttribute('name'), '_blank');
//}

var comp_id = document.getElementById('erw_script').src.split('=')[1];
loadData(comp_id);

function loadData(comp_id) {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "https://beta2.eto-razvod.ru/widget_small.php?comp_id="+comp_id, true);
  xhr.send();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const data = xhr.responseText;
      console.log(data);
      document.getElementById('er_widget_small').innerHTML = data;
    }
  }
}