<br>
<div class="container form-horizontal">
    <% foreach ($archives as $key => $value): %>
    <div class="form-group">
        <label class="col-xs-5 control-label"><%= $key; %></label>
        <div class="col-xs-7">
            <p class="form-control-static"><%= $value; %></p>
        </div>
    </div>
    <% endforeach; %>
</div>
