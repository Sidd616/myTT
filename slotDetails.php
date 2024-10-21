<div class="modal  fade" id="addSlotModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                  <form method="post">
                        <input type="hidden" id="subjectIdInput" name="subject_id" value="">
                        <div class="modal-header">
                              <h1 class="modal-title fs-5" id="addProjectLabel">Slot deatils</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                              <div class="form-input">
                                    <div class="name-input">
                                          <label for="sub_name" class="form-label">Subject</label>
                                          <input name="sub_name" type="text" class="form-control" id="sub_name" placeholder="<?php echo $row['subject_name'] ?>" disabled>

                                    </div>
                                    <div class="name-input">
                                          <label for="slot_type" class="form-label">Type</label>

                                          <select class="form-select" name="slot_type">
                                                <option selected>slot type</option>
                                                <option value="Theory">Theory</option>
                                                <option value="Lab">Lab</option>

                                          </select>
                                    </div>
                                    <div class="name-input">
                                          <label for="slot_day" class="form-label">Day</label>

                                          <select class="form-select" name="slot_day">
                                                <option selected>select day</option>
                                                <option value="1">Monday</option>
                                                <option value="2">Tuesday</option>
                                                <option value="3">Wednesday</option>
                                                <option value="4">Thursday</option>
                                                <option value="5">Friday</option>
                                                <option value="6">Saturday</option>
                                          </select>
                                    </div>
                                    <div class="name-input">
                                          <label for="slot_start" class="form-label">Start</label>

                                          <select class="form-select" name="slot_start">
                                                <option selected>select time</option>
                                                <option value="1">08:00 am</option>
                                                <option value="2">09:00 am</option>
                                                <option value="3">10:00 am</option>
                                                <option value="4">11:15 am</option>
                                                <option value="5">12:15 pm</option>
                                                <option value="6">01:45 pm</option>
                                                <option value="7">02:45 pm</option>
                                                <option value="8">03:45 pm</option>
                                                <option value="9">04:45 pm</option>
                                                <option value="10">05:45 pm</option>
                                          </select>
                                    </div>
                                    <div class="name-input">
                                          <label for="slot_end" class="form-label">End at</label>

                                          <select class="form-select" name="slot_end">
                                                <option selected>select time</option>
                                                <option value="1">08:00 am</option>
                                                <option value="2">09:00 am</option>
                                                <option value="3">10:00 am</option>
                                                <option value="4">11:00 am</option>
                                                <option value="5">11:15 am</option>
                                                <option value="6">12:15 pm</option>
                                                <option value="7">01:15 pm</option>
                                                <option value="8">01:45 pm</option>
                                                <option value="9">02:45 pm</option>
                                                <option value="10">03:45 pm</option>
                                                <option value="11">04:45 pm</option>
                                                <option value="12">05:45 pm</option>
                                                <option value="13">06:45 pm</option>
                                          </select>
                                    </div>
                                    <div class="contact_hour">
                                          <label for="slot_hour" class="form-label">Contact Hour (weekly)</label>
                                          <input name="slot_hour" type="number" class="form-control" id="slot_hour" min="1">

                                    </div>
                                    <div class="contact_hour">
                                          <label for="slot_faculty" class="form-label">Faculty Code</label>
                                          <input name="slot_faculty" type="text" class="form-control" id="slot_faculty">

                                    </div>
                                    <div class="contact_hour">
                                          <label for="slot_room" class="form-label">Room No. </label>
                                          <input name="slot_room" type="text" class="form-control" id="slot_room">

                                    </div>
                                    <div class="contact_hour">
                                          <label for="slot_capacity" class="form-label">Capacity</label>
                                          <input name="slot_capacity" type="number" class="form-control" id="slot_capacity" min="1">

                                    </div>

                              </div>
                        </div>
                        <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                  </form>
            </div>
      </div>
</div>