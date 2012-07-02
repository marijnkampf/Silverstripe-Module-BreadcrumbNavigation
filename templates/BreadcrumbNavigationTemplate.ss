<% if Pages %>
	<div class="breadcrumbnavigation"><% loop Pages %>
		<span class="$FirstLast"><% if isSelf %>$MenuTitle.XML<% else %><a href="$Link">$MenuTitle.XML</a><% end_if %></span> <% if Last %><% else %> &raquo; <% end_if %>
	<% end_loop %></div>
<% end_if %>