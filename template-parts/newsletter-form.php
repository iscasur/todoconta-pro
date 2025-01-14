<div class="subscribe-form">
  <h4 class="subscribe-title">Suscríbete a nuestro boletín</h4>
  <form id="subscribe-form" method="POST">
    <p class="subscribe-subtitle">Y únete a los <strong><?php echo tc_get_subscribers_count(); ?></strong> que ya lo han hecho y no se lo pierden</p>
    <input type="hidden" name="list" value="BuYr892LzE0bp763NocnWz4hxA"/>
    <input type="hidden" name="api_key" value="5a7Ijeup4Dmx0S3QghQ3"/>
    <input type="hidden" name="boolean" value="true"/>
    <div class="subscribe-form-group">
      <input
        type="text"
        name="name"
        placeholder="Nombre"
        required
      >
      <input
        type="email"
        name="email"
        placeholder="Correo electrónico"
        required
      >
      <button
        type="submit"
      >
        ¡Me suscribo!
      </button>
    </div>
    <p id="subscribe-message" class="subscribe-message"></p>
    <p class="subscribe-disclaimer">Te puedes dar de baja cuando quieras. Sin resentimientos. 😊</p>
  </form>
</div>