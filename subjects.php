<?php
$post = new Post();
$result = $post->subject_detail($row['subject_id']);
?>

<div class="project-head">
      <div class="d-flex flex-row gap-2">
            <div class="sub-detail d-flex flex-column justify-content-center align-items-center">
                  <p><?php echo $row['subject_name'] ?></p>
                  <div class="dot-menu" onclick="toggleMenu(event)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" id="dots">
                              <path d="M10.001 7.8a2.2 2.2 0 1 0 0 4.402A2.2 2.2 0 0 0 10 7.8zm0-2.6A2.2 2.2 0 1 0 9.999.8a2.2 2.2 0 0 0 .002 4.4zm0 9.6a2.2 2.2 0 1 0 0 4.402 2.2 2.2 0 0 0 0-4.402z"></path>
                        </svg>
                        <div class="menu" style="display: none;">
                              <ul>
                                    <li onclick="addSlot('<?php echo $row['subject_id'] ?>')">Add Slot</li>
                                    <li onclick="viewList()">View lists</li>
                                    <li onclick="editItem()">Edit</li>
                                    <li onclick="deleteItem()">Delete</li>
                              </ul>
                        </div>
                  </div>
                  <?php
                  include("slotDetails.php");
                  ?>

            </div>
            <?php
            include("subjectSlots.php");
            ?>
      </div>
</div>