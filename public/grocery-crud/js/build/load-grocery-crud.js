
$(() => {
  jQuery(document).ready(function() {
      jQuery('.gc-container').groceryCrud({
          callbackAfterUpdate: function () {
              replace_colors()
          },
          callbackAfterInsert: function () {
              replace_colors()
          },
      });
  });
});

function replace_colors(){
  if($('input[name="primary_color"]').val() != undefined){
      var primary     = $('input[name="primary_color"]').val();
      var secundary   = $('input[name="secundary_color"]').val();
      document.documentElement.style.setProperty('--primary-color', `#${primary == '' ? '8e24aa' : primary}`);
      document.documentElement.style.setProperty('--secondary-color', `#${secundary == '' ? 'ff6e40' : secundary}`);
      document.documentElement.style.setProperty('--primary-rgb', hexToRgb(`${primary == '' ? '8e24aa' : primary}`));
      document.documentElement.style.setProperty('--secondary-rgb', hexToRgb(`${secundary == '' ? 'ff6e40' : secundary}`));
  }
}

function hexToRgb(hex) {
  var bigint = parseInt(hex, 16);
  var r = (bigint >> 16) & 255;
  var g = (bigint >> 8) & 255;
  var b = bigint & 255;
  return `${r}, ${g}, ${b}`;
}