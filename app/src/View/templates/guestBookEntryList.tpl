<div class="container">

    <h1>All guestbook entries</h1>

    {foreach from=$entries item=entry}
    <div class="row">
        <div class="col-xs-2"> id: {$entry.id} </div>
        <div class="col-xs-10"> title: {$entry.title} </div>
    </div>
    {/foreach}


</div>