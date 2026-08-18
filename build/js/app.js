document.addEventListener('DOMContentLoaded', function () {
    cargarBotones()
})

function cargarBotones() {
    const btn_limpiar_nac = document.getElementById('btn_limpiar_nac')
    btn_limpiar_nac.addEventListener('click', () => {
        const input_nac = document.getElementById('nacimiento')
        input_nac.value = ""
    })
    const form_mascota = document.getElementById('form_mascota')
    const btn_limpiar_cancelar = document.getElementById('btn_limpiar_cancelar')
    btn_limpiar_cancelar.addEventListener('click', () => {
        const id = btn_limpiar_cancelar.dataset.id ?? ''

        if (id !== '') {
            window.location.href = 'index.php'
        } else {
            form_mascota.reset()
        }
    })


    const modal_eliminar_mascota = document.querySelector('#modal_eliminar_mascota');
    const btns_abrir_modal = document.querySelectorAll('.btn-abrir-modal');
    const btn_cancelar = document.querySelector('#btn_cancelar');
    const btn_confirmar = document.querySelector('#btn_confirmar');
    const p_mascota_nombre = document.getElementById('p_mascota_nombre');
    const input_mascota_id = document.getElementById('input_mascota_id');

    btns_abrir_modal.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id
            const nombre = btn.dataset.nombre

            input_mascota_id.value = id
            if (p_mascota_nombre && nombre) {
                p_mascota_nombre.textContent = nombre
            }

            modal_eliminar_mascota.showModal()
        })
    })

    btn_cancelar.addEventListener('click', () => {
        modal_eliminar_mascota.close()
    })

    btn_confirmar.addEventListener('click', () => {
        modal_eliminar_mascota.close()
    })

    modal_eliminar_mascota.addEventListener('click', (event) => {
        if (event.target === modal_eliminar_mascota) {
            modal_eliminar_mascota.close()
        }
    })
}