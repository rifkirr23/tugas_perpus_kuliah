<div class="container">
	<div class="row ">			
		<form enctype="multipart/form-data" action="" method="post">
		<div class="form-group  col-sm-3">
			<label>Choose Files</label>
			<input type="file" class="form-control" name="upload_Files[]" multiple/>				
		</div>   
		<div class="form-group  col-sm-6">		
			<input  type="submit" class="btn btn-default" name="submitForm" id="submitForm"/>	
		</div>		
	</div> 	
	<div class="row ">
		<p><?php echo $this->session->flashdata('statusMsg'); ?></p>
	</div>
    <div class="row">
		<div class="gallery">
			<ul>
				<?php if(!empty($gallery)): foreach($gallery as $file): ?>
				<li>
					<img src="<?php echo base_url('uploads/files/'.$file['file_name']); ?>" alt="" >
					<p>Uploaded On <?php echo date("j M Y",strtotime($file['created'])); ?></p>
				</li>
				<?php endforeach; else: ?>
				<p>No File uploaded.....</p>
				<?php endif; ?>
			</ul>
		</div>
    </div>
</div>