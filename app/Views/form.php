<h1>Send your Mail here</h1>
<form method="POST" action="">
    <div class="form-group">
        <label for="SGM_email">To</label>
        <input type="email" name="SGM_email" class="form-control" id="SGM_email" placeholder="Enter email" required>
    </div>
    <div class="form-group">
        <label for="SGM_subject">Subject</label>
        <input type="text" name="SGM_subject" class="form-control" id="SGM_subject" placeholder="Enter your Subject" required>
    </div>
    <div class="form-check">
        <textarea name="SGM_message" id="SGM_message" cols="30" rows="10" placeholder="Enter your Message" required></textarea>
    </div>
    <button type="submit" name="SGM_submit" class="btn btn-primary">Submit</button>
    <?php wp_nonce_field('SGM_email_form');   ?>    
</form>


    

