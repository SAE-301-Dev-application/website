<div class="popup-container popup-hidden" id="<?= $id ?>">
  <div class="popup">
    <div class="popup-close-button">
      <i class="fa-solid fa-xmark"></i>
    </div>

    <h3 class="popup-title">
        <?= $title ?>
    </h3>

    <?= $slot ?>
  </div>
</div>