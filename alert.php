<div id="auto-dismiss-alert" class="alert alert-primary alert-dismissible fade show alert-fixed-top" role="alert">
      <strong>Success!</strong> New creation successful...
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<script>
      // Get the alert element
      var alertElement = document.getElementById("auto-dismiss-alert");

      // Function to hide the alert after 2 seconds
      setTimeout(function() {
            alertElement.classList.remove("show");
            alertElement.classList.add("fade");
      }, 2000);
</script>