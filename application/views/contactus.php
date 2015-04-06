		<div class="content">
			<form role="form" name='contactus-form' method="post" action="<?=current_url()?>">
				<?php if (validation_errors()) { ?>
				<div class="alert alert-danger">
				<?=validation_errors(); ?>
				</div>
				<?php } ?>
                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="text" name="email" id="email" class="form-control" value="<?=$contact['EmailAddress']?>" />
                </div>
                <div class="form-group">
                    <label for="question">Enter your comment/question here</label>
                    <textarea name="question"><?=set_value('question');?></textarea>
                </div>
                <button type="submit" class="btn btn-default pull-right">
                    Submit
                </button>
			</form>
		</div>
