$( document ).ready(function() {
    $('#list-tab a[href="#general"]').tab('show');
});

$('.list-group a').click(function() {
      $(this).siblings('a').removeClass('active');
      $(this).addClass('active');
  });

$('#list-tab a[href="#general"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#messages"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#abonnement"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#services"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#historique"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#desactive"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});
