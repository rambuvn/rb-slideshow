(($) => {
  'use strict';

  // Function to update media ids 
  const updateMedia = () => {
    let slideField = $('#rb-slideshow-images');
    let ids = $('.rb-sortable .item').map((i, el)=> parseInt(el.getAttribute('data-attachment-id')||false)).filter((i,el)=>el)
    slideField.val(Array.from(ids).join(','));
  }

  $( ".rb-sortable" ).sortable({
    items: '.item',
    placeholder: "item--highlight",
    update: updateMedia 
  }).disableSelection();

  $('.rb-sortable .item .item--remove').on('click', (e) => {
    let target = $(e.currentTarget);
    target.closest('.item').remove(); 
   
    updateMedia(); 
  })

  // Create media add new button for slideshow images setting
  $('.rb-sortable .button').click(function(e) {
      e.preventDefault();
        let rbMedia = wp.media({ 
        title: 'Add Slideshow Image',
        multiple: true
      }).open()
      .on('select', function(e){
          var uploaded_images = rbMedia.state().get('selection');
          
          if ( uploaded_images.length > 0 ) {
            uploaded_images.forEach(media => {
              let image = media.toJSON()
              let slideItem = document.createElement('li');
              slideItem.classList.add('item');
              slideItem.setAttribute('data-attachment-id', image.id);
              slideItem.innerHTML = `<img src="${image.url}" alt="${image.title}" />`;

              $('.rb-sortable .button').before(slideItem);
              // Trigger update setting media list
              updateMedia();
            })
          }
          
          
      });
  });
})(jQuery);