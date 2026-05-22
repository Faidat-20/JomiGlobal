// Quantity picker
const qtyMinus = document.getElementById('qtyMinus');
const qtyPlus = document.getElementById('qtyPlus');
const productQty = document.getElementById('productQty');

if (qtyMinus && qtyPlus && productQty) {
  qtyMinus.addEventListener('click', () => {
    const val = parseInt(productQty.value);
    if (val > 1) productQty.value = val - 1;
  });

  qtyPlus.addEventListener('click', () => {
    const val = parseInt(productQty.value);
    const max = parseInt(productQty.getAttribute('max'));
    if (val < max) productQty.value = val + 1;
  });
}