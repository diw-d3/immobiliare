var $ = jQuery;

$('#housing-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var reference = button.data('title');

    // On change le value du input de la modal
    // avec le data-title du bouton cliqué
    $('#reference').val(reference);
    $('.modal-title').text(reference);
    $('#housing_id').val(button.data('id'));
});

/*
 Pour tester le JS, on veut changer la couleur du h1 au survol et le passer en rouge.
 On quitte le survol, et le h1 redevient noir.
*/
console.log($('h1'));

$('h1').hover(
	function () {
		$(this).css('color', 'red');
	},
	function () {
		$(this).css('color', '#000');
	}
);
