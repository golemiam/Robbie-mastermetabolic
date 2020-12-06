function changeSession(user, page, id){
	var url = '/user/'+user+'/'+page+'/'+id;
	window.location = url;
}