<?php 
$title = 'Contact & Request an Estimate | Midcity Handyman & Remodeling';
$description = 'Contact Midcity Handyman & Remodeling in Lockport, NY. View business hours, phone number, service area, and request an estimate.';
include __DIR__ . '/../includes/header.php';
?>

<section class="page-hero">
  <div class="wrap">
    <p class="eyebrow">Get In Touch</p>
    <h1>Contact Midcity Handyman &amp; Remodeling</h1>
    <p class="lead">Have a project in mind or need an on-site assessment? Reach out to our team by phone, email, or by completing the estimate request form below.</p>
  </div>
</section>

<section class="section white">
  <div class="wrap">
    <div class="section-head">
      <p class="eyebrow">Business Details &amp; Office Info</p>
      <h2>Contact Information &amp; Service Radius</h2>
      <p>Official business details, office contact info, operating hours, and service area coverage for Midcity Handyman &amp; Remodeling.</p>
    </div>

    <div class="contact-info-grid">
      <div class="contact-info-card">
        <h3>Business Name</h3>
        <p><strong><?= e(config()['site_name']) ?></strong></p>
        <p style="margin-top: 6px; font-size: 14px; color: var(--muted);">Licensed &amp; Insured General Contractor</p>
      </div>

      <div class="contact-info-card">
        <h3>Phone &amp; Email</h3>
        <p><strong>Phone:</strong> <a href="tel:<?= e(config()['phone_href']) ?>"><?= e(config()['phone']) ?></a></p>
        <p style="margin-top: 6px;"><strong>Email:</strong> <a href="mailto:<?= e(config()['email']) ?>"><?= e(config()['email']) ?></a></p>
      </div>

      <div class="contact-info-card">
        <h3>Business Hours</h3>
        <p><strong>Monday – Friday:</strong> 8:00 AM – 5:00 PM</p>
        <p><strong>Saturday &amp; Sunday:</strong> Closed</p>
      </div>

      <div class="contact-info-card">
        <h3>Address &amp; Service Radius</h3>
        <p>Midcity Handyman &amp; Remodeling proudly services a 45 mile radius of Lockport, NY 14094.</p>
      </div>

      <div class="contact-info-card full-width">
        <h3>Company Overview</h3>
        <p>Midcity Handyman &amp; Remodeling is a premier general contracting and handyman service provider based in Lockport, New York. We specialize in residential bathroom and kitchen remodeling, basement finishing, property management turnovers, closing and compliance repairs, storm/insurance repairs, and ongoing property maintenance. Serving homeowners, realtors, property managers, and landlords throughout Western New York, our mission is to deliver dependable communication, clear written estimates, and lasting craftsmanship on every project.</p>
      </div>
    </div>
  </div>
</section>

<section class="section soft">
  <div class="wrap split">
    <div>
      <h2 style="margin-bottom:12px;">Request an On-Site Estimate</h2>
      <p style="margin-bottom:24px; color:var(--muted);">Share your project details, property address, and preferred timeline to schedule an assessment.</p>
      <?php include __DIR__ . '/../includes/lead-form.php'; ?>
    </div>
    <div>
      <p class="eyebrow">What happens next</p>
      <h2>A real assessment, not a vague ballpark.</h2>
      <ul class="check-list">
        <li>We review your project information</li>
        <li>We confirm fit and service area</li>
        <li>We schedule an on-site assessment</li>
        <li>You receive a written scope and estimate</li>
      </ul>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>