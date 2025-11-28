document.addEventListener("DOMContentLoaded", function () {
  const radios = document.querySelectorAll('input[name="selected_address"]');
  const addrInput = document.querySelector('input[name="address"]');
  const cityInput = document.querySelector('input[name="city"]');
  const zipInput = document.querySelector('input[name="postal_code"]');
  const provInput = document.querySelector('input[name="province"]');

  function setInputs(props, readonly) {
    if (!addrInput) return;
    addrInput.value = props.street || "";
    cityInput.value = props.city || "";
    zipInput.value = props.postal || "";
    provInput.value = props.province || "";
    addrInput.readOnly =
      cityInput.readOnly =
      zipInput.readOnly =
      provInput.readOnly =
        !!readonly;
  }

  radios.forEach(function (r) {
    r.addEventListener("change", function () {
      if (this.value === "new") {
        setInputs({}, false);
      } else {
        setInputs(
          {
            street: this.dataset.street,
            city: this.dataset.city,
            postal: this.dataset.postal,
            province: this.dataset.province,
          },
          true
        );
      }
    });
  });

  // update hidden selected_address_id when radio changes
  const selectedAddressHidden = document.getElementById('selected_address_id');
  radios.forEach(function (r) {
    r.addEventListener('change', function () {
      if (selectedAddressHidden) {
        selectedAddressHidden.value = this.value;
      }
    });
  });

  // initialize based on checked radio (if any)
  const checked = document.querySelector(
    'input[name="selected_address"]:checked'
  );
  if (checked) checked.dispatchEvent(new Event("change"));
});
