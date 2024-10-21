<?php

if ($row['subject_type'] == 'ALC') {
      include('alcSubject.php');
} elseif ($row['subject_type'] == 'Opted') {
      include('optedSubject.php');
} else {
      echo '<div style="text-align: center; color: #a0a0a0;">
                        No Optional Subjects found
                        <br>
                        This form is ONLY for Optional Subjects.
                      </div>';
}
