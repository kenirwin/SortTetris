<?php if ( ! empty($user->errors)): ?>
  <ul>
    <?php foreach ($user->errors as $error): ?>
      <li><?php echo $error; ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<form method="post" id="userForm" class="uk-form uk-form-horizontal">
  <div class="uk-form-row">
    <label for="name" class="uk-form-label">Name</label>
    <div class="uk-form-controls">
      <input id="name" name="name" required="required" value="<?php echo htmlspecialchars($user->name); ?>" />
    </div>
  </div>

  <div class="uk-form-row">
    <label for="email" class="uk-form-label">email address</label>
    <div class="uk-form-controls">
      <input id="email" name="email" required="required" type="email" value="<?php echo htmlspecialchars($user->email); ?>" />
    </div>
  </div>

  <div class="uk-form-row">
    <label for="password" class="uk-form-label">Password</label>
    <div class="uk-form-controls">
      <input type="password" id="password" name="password" />
      <?php if (isset($user->id)): ?><p class="uk-form-help-block">Leave blank to keep current password</p><?php endif; ?>
    </div>
  </div>

  <?php $is_same_user = $user->id == Auth::getInstance()->getCurrentUser()->id; ?>

  <div class="uk-form-row">
    <div class="uk-form-controls uk-form-controls-text">
      <label for="is_active" class="uk-form-label">
        <?php if ($is_same_user): ?>
          <input type="hidden" name="is_active" value="1" />
          <input type="checkbox" disabled="disabled" checked="checked" /> active

        <?php else: ?>
          <input id="is_active" name="is_active" type="checkbox" value="1"
                 <?php if ($user->is_active): ?>checked="checked"<?php endif; ?>/> active

        <?php endif; ?>
      </label>
    </div>
  </div>

  <div class="uk-form-row">
    <div class="uk-form-controls uk-form-controls-text">
      <label for="is_admin" class="uk-form-label">
        <?php if ($is_same_user): ?>
          <input type="hidden" name="is_admin" value="1" />
          <input type="checkbox" disabled="disabled" checked="checked" /> administrator

        <?php else: ?>
          <input id="is_admin" name="is_admin" type="checkbox" value="1"
                 <?php if ($user->is_admin): ?>checked="checked"<?php endif; ?>/> administrator

        <?php endif; ?>
      </label>
    </div>
  </div>

  <div class="uk-form-row">
    <div class="uk-form-controls">
      <button class="uk-button uk-button-primary">Save</button>
      <a href="/admin/users<?php if (isset($user->id)) { echo '/show.php?id=' . $user->id; } ?>">Cancel</a>
    </div>
  </div>
</form>

<script>
  $userID = <?php echo isset($user->id) ? $user->id : 'null'; ?>;
</script>
