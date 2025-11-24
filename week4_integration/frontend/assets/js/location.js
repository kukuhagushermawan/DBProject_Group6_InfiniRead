// /frontend/assets/js/location.js

document.addEventListener('DOMContentLoaded', () => {
  const provSelect = document.getElementById('province');
  const citySelect = document.getElementById('city');

  if (!provSelect || !citySelect) return; // kalau bukan halaman yg pakai dropdown ini

  // --- helper untuk render opsi city ---
  function renderCityOptions(cities, selectedId) {
    citySelect.innerHTML = '<option value="">Pilih City</option>';

    cities.forEach((c) => {
      const opt = document.createElement('option');
      opt.value = c.City_ID;
      opt.textContent = c.City_Name;

      if (String(c.City_ID) === String(selectedId)) {
        opt.selected = true;
      }
      citySelect.appendChild(opt);
    });

    citySelect.disabled = false;
  }

  // --- fungsi load city dari server ---
  async function loadCities(provinceId, selectedCityId = '') {
    if (!provinceId) {
      citySelect.innerHTML = '<option value="">Pilih City</option>';
      citySelect.disabled = true;
      return;
    }

    citySelect.disabled = true;
    citySelect.innerHTML = '<option value="">Memuat data city...</option>';

    try {
      // SESUAIKAN path API ini dengan punyamu
      const res = await fetch(
        '/backend/api/cities.php?province_id=' + encodeURIComponent(provinceId)
      );

      if (!res.ok) {
        throw new Error('Response tidak OK');
      }

      const data = await res.json(); // expected: [{City_ID:1, City_Name:"KOTA A"}, ...]
      renderCityOptions(data, selectedCityId);
    } catch (err) {
      console.error('Gagal load cities:', err);
      citySelect.innerHTML =
        '<option value="">Gagal memuat city</option>';
    }
  }

  // --- event saat user mengubah province (register & profile) ---
  provSelect.addEventListener('change', () => {
    const provId = provSelect.value;
    loadCities(provId, '');
  });

  // --- auto-load untuk halaman PROFILE (data lama sudah ada) ---
  const oldProv = window._oldProvince || provSelect.value || '';
  const oldCity = window._oldCity || '';

  if (oldProv) {
    // kalau ada provinsi lama, langsung muat city + pilih city lama
    loadCities(oldProv, oldCity);
  }
});
