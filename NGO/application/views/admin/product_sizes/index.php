<!-- Modifier list template -->
<script type="text/template" id="template-size-modifiers-list">

   <% if (!_.isEmpty(response.sizes)) { %>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="40%">Size</th>
                    <th width="30%">Price</th>
                    <th width="30%" colspan="2">Action</th>
                </tr>
            </thead>

            <tbody>
                <% _.each(response.sizes, function(row) {
                    editurl='admin/product_sizes/edit/' + response.product_id+ '/' + row.id 
                    url='/product_sizes/delete/' + response.product_id+ '/' + row.id 
                %>
                    <tr>
                        <td><%=row.sizes%></td>
                        <td><%=response.currency_symbol%> <%=row.price%></td>
                        <td><a href="<%=editurl %>" data-toggle="modal" data-target="#ajaxModalSize" class="btn-link">Edit</a></td>
                        <td><a href="javascript:void(0);" class="btn-link btn-product-mod-size" data-href="<%=url %>" data-toggle="tooltip" data-placement="bottom" data-original-title="Delete">Delete</a></td>
                    </tr>
                <% }) %>
            </tbody>
        </table>
     <% }%>
</script>



