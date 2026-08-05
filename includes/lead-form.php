<?php
$form_title = $form_title ?? 'Book Your Free Site Visit';
$form_subtitle = $form_subtitle ?? 'Tell us what you need. We will review the details and contact you to schedule the next step.';
$form_service = $form_service ?? ($_GET['service'] ?? '');
$form_context = $form_context ?? 'Website estimate request';
?>
<form class="form-card wizard-form" data-lead-form data-wizard-form>
  <input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
  <input type="hidden" name="context" value="<?=e($form_context)?>">
  <input type="text" name="website" tabindex="-1" autocomplete="off" class="hp-field" aria-hidden="true">
  <div class="wizard-heading"><p class="eyebrow">Free project consultation</p><h3><?=e($form_title)?></h3><p><?=e($form_subtitle)?></p></div>
  <div class="wizard-progress" aria-label="Form progress">
    <div class="wizard-node active"><b>1</b><span>Project</span></div><i></i>
    <div class="wizard-node"><b>2</b><span>Details</span></div><i></i>
    <div class="wizard-node"><b>3</b><span>Contact</span></div>
  </div>
  <section class="wizard-step active" data-step="1">
    <h4>What can we help with?</h4><p class="step-copy">Choose the closest project type. You can add specifics on the next step.</p>
    <div class="choice-grid">
      <?php foreach(services() as $i=>$s): $icons = ['bath','kitchen','home','turnover','check','rain','hammer','list']; $icon = $icons[$i] ?? 'tool'; ?><label class="choice-card"><input type="radio" name="service" value="<?=e($s['name'])?>" <?=($form_service===$s['name'] || (!$form_service && $i===0))?'checked':''?>><span class="choice-icon choice-icon-<?=$icon?>" aria-hidden="true"></span><span><strong><?=e($s['name'])?></strong><small><?=e($s['summary'])?></small></span></label><?php endforeach;?>
    </div>
    <div class="wizard-actions end"><button class="button wizard-next" type="button">Next: Project Details →</button></div>
  </section>
  <section class="wizard-step" data-step="2">
    <h4>Tell us about the property and timeline</h4>
    <div class="form-grid">
      <div class="field full"><label>Property address or city *</label><input name="address" required placeholder="Street address, city, or service area"></div>
      <div class="field"><label>Preferred timing</label><select name="timeline"><option>As soon as possible</option><option>Within 30 days</option><option>1–3 months</option><option>3–6 months</option><option>Planning ahead</option></select></div>
      <div class="field"><label>Estimated budget</label><select name="budget"><option value="">Select a range</option><option>Under $5,000</option><option>$5,000–$15,000</option><option>$15,000–$30,000</option><option>$30,000–$60,000</option><option>$60,000+</option><option>Not sure yet</option></select></div>
      <div class="field full"><label>Project details *</label><textarea name="message" required placeholder="Describe the current condition, desired work, deadlines, and anything we should know before the site visit."></textarea></div>
    </div>
    <div class="wizard-actions"><button class="button ghost wizard-prev" type="button">← Back</button><button class="button wizard-next" type="button">Next: Contact →</button></div>
  </section>
  <section class="wizard-step" data-step="3">
    <h4>How should we reach you?</h4>
    <div class="form-grid">
      <div class="field"><label>Your name *</label><input name="name" required autocomplete="name"></div>
      <div class="field"><label>Phone number *</label><input name="phone" required autocomplete="tel"></div>
      <div class="field full"><label>Email address *</label><input type="email" name="email" required autocomplete="email"></div>
      <div class="field full"><label>Best contact method</label><div class="inline-options"><label><input type="radio" name="contact_method" value="Phone" checked> Phone</label><label><input type="radio" name="contact_method" value="Text"> Text</label><label><input type="radio" name="contact_method" value="Email"> Email</label></div></div>
      <div class="field full"><label class="consent"><input type="checkbox" name="consent" required> I agree that Mid City Home Restoration may contact me about this request.</label></div>
    </div>
    <div class="wizard-actions"><button class="button ghost wizard-prev" type="button">← Back</button><button class="button" type="submit">Book My Free Site Visit</button></div>
    <div class="notice" role="status"></div>
  </section>
</form>
