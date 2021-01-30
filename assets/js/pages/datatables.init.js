$(document).ready(function(){
	$("#basic-datatable").DataTable({
			language:{
				paginate:{ 
					previous:"<i class='mdi mdi-chevron-left'>",
					next:"<i class='mdi mdi-chevron-right'>"}
				},
				order: [[ 1, "desc" ]],
				drawCallback:function(){
					$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
				}
			});
	});