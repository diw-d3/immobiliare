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
