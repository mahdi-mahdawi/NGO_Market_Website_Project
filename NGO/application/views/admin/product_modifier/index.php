<!-- Modifier list template -->
<script type="text/template" id="template-item-modifiers-list">
    <% _.each(response.modifiers, function(modifier) { %>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="2">
                        <%=modifier.name%>
                        <div class="pull-right">
                            <% 
                                url='/product_modifier/delete/' + response.product_id + '/' + modifier.id
                                editurl='admin/product_modifier/edit/' + response.product_id + '/' + modifier.id
                            %>
                            
                            <a href="<%=editurl %>" data-toggle="modal" data-target="#ajaxModal" class="btn-link">Edit</a>
                            <a href="javascript:void(0);" class="btn-link btn-modi" data-href="<%=url %>" data-toggle="tooltip" data-placement="bottom" data-original-title="Delete">Delete</a>
                        </div>
                    </th>
                </tr>
            </thead>

            <tbody>
                <% _.each(modifier.items, function(row) { %>
                    <tr>
                        <td width="80%"><%=row.name%></td>
                        <td width="40%"><center><%=response.currency_symbol%> <%=row.price%></center></td>
                    </tr>
                <% }) %>
            </tbody>
        </table>
    <% }) %>
</script>



