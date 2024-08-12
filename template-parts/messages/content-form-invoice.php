<form method="POST" action="/post-message" class="raise_invoice">
<h2>Invoice</h2>

<input type="hidden" name="thread_id" value="<?= $post->ID;?>" /> 
<input type="hidden" name="type" value="invoice" /> 

<div class="row space-between">
    <p>Invoice amount  £</p>
    <input type="number" name="invoice_amount"/>
</div>

<textarea placeholder="Enter your message" name="message"></textarea>
<button type="button" id="upload_files">Attach files</button>

 
<button type="submit">Submit invoice request</button>
</form>
