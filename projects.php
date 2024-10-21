<?php
$encrypted_project_id = base64_encode($row['project_id']);
?>


<a class="drop-bt"><?php echo $row['project_name'] ?>
</a>
<div class="dropdown-container inner">
      <a class="sideA" href="moodle.php?project=<?php echo $encrypted_project_id; ?>">Moodle</a>
      <a class="sideA" href="activationForm.php?form=<?php echo $encrypted_project_id; ?>">Forms</a>
      <a class="sideA" href="projectActivation.php?active=<?php echo $encrypted_project_id; ?>">Activation</a>
      <a class="sideA" href="#">Allotments</a>
      <a class="sideA" href="#">Search TT</a>
</div>