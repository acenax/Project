<form id="save_profile">
    <input type="hidden" name="action" value="save_profile">
    <div class="row">
        <!-- ... -->
        <div class="col-12">
            <div class="mb-3">
                <!-- ... -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo $rows_user['user_email']; ?>">
                    <?php if (isset($email_error) && $email_error) { ?>
                        <div class="text-danger mt-2">
                            Email is not correct. Please try again.
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- ... -->
</form>