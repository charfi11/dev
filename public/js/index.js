$(document).ready(function(){
    var l = $('#list').children()
    l.each(function(){
    $($(this)).on('click', (ev) => {
     ev.preventDefault();
     $('#load').show();
     var url = ev.target.href
     var data = {'id' : ev.target.id}
     $.ajax({
         url: url,
         data: data
     })
     .done(function(res){
        data
        if(res){
        $('#load').hide();
        }
        $('#l').css('visibility', 'visible')
        $('#l').empty()
        $('#l').append('<i class="fas fa-window-close" id="cl"></i>')
        $('#cl').on('click', () => {
            $('#l').empty();
            $('#l').css('visibility', 'hidden');
        })
        res.forEach(e => {
            $('#l').append('<a class="card animate__animated animate__flipInX col s3" href='+'/category/'+e.id+'>'+'<div class="bodycard">'+'<img class="cardimg" src='+e.img+'>'
            +'<p>'+e.name+'</p>'+'</div>'+'</a>')
        })
      })
    })
  })
})

$(document).on('click', '.deleteast', function(event){
  event.preventDefault();
  const url = this.href;
  const id = this.id;
  const data = {'id' : id};
  const carda = $(this).parent().parent();

  $.ajax({
  url: url,
  dataType: 'json',
  data: data,
  success:function(){
      data;
      $(carda).remove();
  }
  })
})