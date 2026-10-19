<?php
define('APP_INIT', true);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/data.php';

$submitted = false;
$inquiryData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $company = isset($_POST['company']) ? trim($_POST['company']) : '';
    $quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
    $interest = isset($_POST['interest']) ? trim($_POST['interest']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if (!empty($name) && (!empty($phone) || !empty($email))) {
        $submitted = true;
        $inquiryData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'quantity' => $quantity,
            'interest' => $interest,
            'message' => $message
        ];
    }
}

$pageTitle = 'Contact Us';
include_once __DIR__ . '/includes/header.php';
?>

<div class="bg-neutral-900 text-white py-12 border-b border-neutral-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <span class="text-gold text-xs font-bold tracking-widest uppercase block mb-2">Get In Touch</span>
    <h1 class="text-3xl sm:text-4xl font-extrabold font-serif">Contact Panna Heera Perfumery</h1>
    <p class="mt-2 text-neutral-400 text-sm max-w-xl mx-auto">
      Request wholesale samples, custom bottle quotations, or schedule a visit to our Mumbai showroom.
    </p>
  </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
    
    <!-- Contact Details & Quick Links (5 cols) -->
    <div class="lg:col-span-5 space-y-8">
      <div>
        <h2 class="text-xl font-bold text-neutral-900 mb-2">Wholesale & B2B Inquiry Desk</h2>
        <p class="text-xs text-neutral-600 leading-relaxed">
          Our packaging technical consultants assist fragrance creators with bottle dimensions, pump specifications, and custom branding proofs.
        </p>
      </div>

      <div class="space-y-4 text-xs">
        <div class="flex items-start gap-4 p-4 bg-neutral-50 rounded-xl border border-neutral-100">
          <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-lg flex-shrink-0">
            📍
          </div>
          <div>
            <strong class="text-neutral-900 block font-semibold mb-0.5">Showroom & Warehouse</strong>
            <p class="text-neutral-600"><?php echo COMPANY_ADDRESS; ?></p>
          </div>
        </div>

        <div class="flex items-start gap-4 p-4 bg-neutral-50 rounded-xl border border-neutral-100">
          <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-lg flex-shrink-0">
            💬
          </div>
          <div>
            <strong class="text-neutral-900 block font-semibold mb-0.5">Direct WhatsApp Support</strong>
            <p class="text-neutral-600 mb-1">Instant catalog sharing, price quotes & real-time video inspection.</p>
            <a href="<?php echo getWhatsAppLink(); ?>" target="_blank" class="text-[#25D366] font-bold hover:underline">
              Chat on WhatsApp &rarr;
            </a>
          </div>
        </div>

        <div class="flex items-start gap-4 p-4 bg-neutral-50 rounded-xl border border-neutral-100">
          <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-lg flex-shrink-0">
            📞
          </div>
          <div>
            <strong class="text-neutral-900 block font-semibold mb-0.5">Phone & Inquiries</strong>
            <p class="text-neutral-600"><?php echo PHONE_NUMBER; ?></p>
            <p class="text-[11px] text-neutral-400 mt-0.5"><?php echo BUSINESS_HOURS; ?></p>
          </div>
        </div>

        <div class="flex items-start gap-4 p-4 bg-neutral-50 rounded-xl border border-neutral-100">
          <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-lg flex-shrink-0">
            ✉️
          </div>
          <div>
            <strong class="text-neutral-900 block font-semibold mb-0.5">Email Communications</strong>
            <a href="mailto:<?php echo CONTACT_EMAIL; ?>" class="text-neutral-700 hover:text-gold transition">
              <?php echo CONTACT_EMAIL; ?>
            </a>
          </div>
        </div>
      </div>

      <!-- Quick WhatsApp CTA Box -->
      <div class="p-6 bg-gradient-to-br from-neutral-900 to-neutral-800 text-white rounded-2xl shadow-md">
        <h3 class="font-bold text-sm text-white mb-2">Need Samples Urgently?</h3>
        <p class="text-xs text-neutral-300 mb-4 leading-relaxed">
          Order a curated discovery sample box of our Cyrill, Victor, Saab bottles and Zamac magnetic caps delivered within 48 hours.
        </p>
        <a href="<?php echo getWhatsAppLink('Hi Panna Heera Perfumery, I would like to order a sample box of your bottles and caps.'); ?>" target="_blank" class="bg-[#25D366] hover:bg-[#20ba5a] text-white py-2.5 px-5 rounded-full text-xs font-bold inline-flex items-center gap-2 transition">
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
          Order Sample Box on WhatsApp
        </a>
      </div>
    </div>

    <!-- Inquiry Form (7 cols) -->
    <div class="lg:col-span-7">
      <div class="bg-white p-6 sm:p-8 rounded-2xl border border-neutral-200 shadow-sm">
        
        <?php if ($submitted): ?>
          <div class="p-6 bg-emerald-50 border border-emerald-200 rounded-xl mb-6 text-emerald-800">
            <h3 class="font-bold text-sm mb-1">✓ Thank you for reaching out, <?php echo htmlspecialchars($inquiryData['name']); ?>!</h3>
            <p class="text-xs text-emerald-700 leading-relaxed mb-4">
              Your inquiry has been logged with our sales team. For immediate reply, you can also forward your details straight to our WhatsApp dispatch desk:
            </p>
            <?php
            $waSummary = "Hello Panna Heera Perfumery,\n\nName: {$inquiryData['name']}\nCompany: {$inquiryData['company']}\nPhone: {$inquiryData['phone']}\nInterest: {$inquiryData['interest']}\nQuantity: {$inquiryData['quantity']}\nMessage: {$inquiryData['message']}";
            ?>
            <a href="<?php echo getWhatsAppLink($waSummary); ?>" target="_blank" class="inline-flex items-center gap-2 bg-[#25D366] text-white px-5 py-2 rounded-full text-xs font-bold hover:bg-[#20ba5a] transition">
              Click Here to Forward Inquiry to WhatsApp &rarr;
            </a>
          </div>
        <?php endif; ?>

        <h2 class="text-lg font-bold text-neutral-900 mb-1">Request a Bulk Quote / Sample</h2>
        <p class="text-xs text-neutral-500 mb-6">Fill out the specifications below and our engineering team will respond within 2 hours.</p>

        <form method="POST" action="contact.php" class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Your Full Name *</label>
              <input type="text" name="name" required placeholder="e.g. Rajesh Sharma" class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900">
            </div>
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Company / Brand Name</label>
              <input type="text" name="company" placeholder="e.g. Royale Fragrances" class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900">
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Phone / WhatsApp Number *</label>
              <input type="tel" name="phone" required placeholder="+91 98765 43210" class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900">
            </div>
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Email Address</label>
              <input type="email" name="email" placeholder="name@yourbrand.com" class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900">
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Product of Interest</label>
              <select name="interest" class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white">
                <option value="Complete Bottle Sets">Complete Bottle Sets (100ml / 50ml / 30ml)</option>
                <option value="100ml Cyrill Glass Bottle">100ml Cyrill Glass Bottle</option>
                <option value="100ml Victor Glass Bottle">100ml Victor Glass Bottle</option>
                <option value="10ml Tester Vials & Pumps">10ml Tester Vials & Pumps</option>
                <option value="20ml Saab Bottle Set">20ml Saab Bottle Set</option>
                <option value="Zamac Magnetic Caps">Zamac Magnetic Caps</option>
                <option value="Fine Mist Pumps">Fine Mist Pumps (FEA 15)</option>
                <option value="Custom Glass Mould">Custom Glass Mould Development</option>
                <option value="Fragrance Oils & Raw Compounds">Fragrance Oils & Raw Compounds</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Anticipated Quantity</label>
              <select name="quantity" class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900 bg-white">
                <option value="Sample Pack (50 - 100 pcs)">Sample Pack (50 - 100 pcs)</option>
                <option value="Pilot Batch (500 - 1,000 pcs)">Pilot Batch (500 - 1,000 pcs)</option>
                <option value="Standard Run (2,000 - 5,000 pcs)">Standard Run (2,000 - 5,000 pcs)</option>
                <option value="Wholesale Pallet (10,000+ pcs)">Wholesale Pallet (10,000+ pcs)</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-neutral-700 mb-1">Project Details / Requirements</label>
            <textarea name="message" rows="4" placeholder="Tell us about your neck specifications, desired cap color, silk screen printing needs, or delivery timeline..." class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-neutral-300 focus:outline-none focus:border-neutral-900"></textarea>
          </div>

          <button type="submit" class="w-full bg-neutral-900 hover:bg-black text-white py-3.5 rounded-full text-xs font-bold tracking-wider uppercase transition shadow-md">
            Submit Wholesale Inquiry
          </button>
        </form>

      </div>
    </div>

  </div>

  <!-- Frequently Asked Questions Accordion -->
  <div class="mt-20 pt-12 border-t border-neutral-200">
    <div class="text-center mb-10">
      <span class="text-xs font-bold uppercase tracking-widest text-gold block mb-1">Everything You Need To Know</span>
      <h2 class="text-2xl font-extrabold text-neutral-900">Frequently Asked Questions</h2>
    </div>

    <div class="max-w-3xl mx-auto space-y-4 text-xs">
      <div class="p-5 bg-neutral-50 rounded-xl border border-neutral-200">
        <h3 class="font-bold text-neutral-900 mb-1.5 text-sm">What is the Minimum Order Quantity (MOQ)?</h3>
        <p class="text-neutral-600 leading-relaxed">
          For in-stock standard models (like Cyrill, Victor, and Saab sets), our trial MOQ is only 50 to 100 pieces so independent perfumers can launch with low inventory risk. For custom color spray lacquering or silk screen printing, MOQ starts at 500 pieces. For custom shape private glass molds, production runs start at 5,000 to 10,000 pieces.
        </p>
      </div>

      <div class="p-5 bg-neutral-50 rounded-xl border border-neutral-200">
        <h3 class="font-bold text-neutral-900 mb-1.5 text-sm">Can I test samples before placing a commercial order?</h3>
        <p class="text-neutral-600 leading-relaxed">
          Yes, sample kits with complete bottles, pumps, and closures can be dispatched immediately via express courier. You can test fragrance oil compatibility, spray cloud pattern, and cap retention before finalizing your order.
        </p>
      </div>

      <div class="p-5 bg-neutral-50 rounded-xl border border-neutral-200">
        <h3 class="font-bold text-neutral-900 mb-1.5 text-sm">What is the difference between Crimp Neck and Screw Neck?</h3>
        <p class="text-neutral-600 leading-relaxed">
          Crimp neck bottles (such as FEA 15mm) use a permanent pneumatic or manual crimping collar that provides an airtight, tamper-proof luxury seal standard in prestige European perfumes. Screw neck bottles (like 18/415 or 14mm) screw on and off manually without needing any crimping machinery, making them ideal for refillable perfumes or boutique workshops.
        </p>
      </div>

      <div class="p-5 bg-neutral-50 rounded-xl border border-neutral-200">
        <h3 class="font-bold text-neutral-900 mb-1.5 text-sm">How do you prevent breakage during transit?</h3>
        <p class="text-neutral-600 leading-relaxed">
          All glass flacons are packed in honeycomb cell partition trays, sealed inside double-wall corrugated export master cartons, and shrink-wrapped onto wooden pallets for bulk freight. We offer a 100% transit breakage replacement warranty.
        </p>
      </div>
    </div>
  </div>

</div>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
