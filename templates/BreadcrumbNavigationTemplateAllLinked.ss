<% if Pages %>
	<div class="breadcrumbnavigation"><% loop Pages %>
		<span class="$FirstLast"><a href="$Link">$MenuTitle.XML</a></span> <% if Last %><% else %> &raquo; <% end_if %>
	<% end_loop %></div>
<% end_if %>