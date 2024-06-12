<script>
  var alerts = document.getElementById("alerts");

  var close = document.getElementsByClassName("alert-closebtn");
  var i;

  // Loop through all close buttons
  for (i = 0; i < close.length; i++) {
    // When someone clicks on a close button
    close[i].onclick = function () {

      // Get the parent of <span class="closebtn"> (<div class="alert">)
      var div = this.parentElement;

      // Set the opacity of div to 0 (transparent)
      div.style.opacity = "0";

      // Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
      setTimeout(function () { div.style.display = "none"; }, 600);
    }
  }
  var alert_counter = 0;
  function Alert(type, message) {
    if (type == "success") alerts.insertAdjacentHTML('beforeend', '<div id="alert_' + alert_counter + '" class="alert fade-in alert_success"><span class="alert-closebtn" onclick="this.parentElement.style.display =  \'none\'; ">&times;</span>' + message + '</div>');
    else if (type == "danger") alerts.insertAdjacentHTML('beforeend', '<div id="alert_' + alert_counter + '" class="alert fade-in alert_danger"><span class="alert-closebtn" onclick="this.parentElement.style.display =  \'none\'; ">&times;</span>' + message + '</div>');
    else if (type == "info") alerts.insertAdjacentHTML('beforeend', '<div id="alert_' + alert_counter + '" class="alert fade-in alert_info"><span class="alert-closebtn" onclick="this.parentElement.style.display = \'none\'; ">&times;</span>' + message + '</div>');
    else if (type == "warning") alerts.insertAdjacentHTML('beforeend', '<div id="alert_' + alert_counter + '" class="alert fade-in alert_warning"><span class="alert-closebtn" onclick="this.parentElement.style.display = \'none\'; ">&times;</span>' + message + '</div>');
    hideAlert("alert_" + alert_counter);
    alert_counter++;

  }
  function hideAlert(id) {
    var elem = document.getElementById(id);
    elem.classList.remove('fade-in');

    setTimeout(function () {
      elem.style.display = 'none'; elem.classList.add('fade-out');
    }, 6000);
  }

</script>