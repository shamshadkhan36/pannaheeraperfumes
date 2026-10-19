<?php
/**
 * Special Offer Campaign Hero Slide
 */
?>
<section class="hero-banner hero-offer-banner relative flex items-center overflow-hidden" style="background-image: url('<?php echo htmlspecialchars($offerBgImage); ?>');">
  <!-- Subtle dark vignette & golden ambient glow -->
  <div class="hero-overlay"></div>
  
  <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20 w-full">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
      
      <!-- Left Column: High-Impact Offer Copy & Controls -->
      <div class="lg:col-span-7 text-white space-y-4 sm:space-y-5">
        
        <!-- Badges Row -->
        <div class="flex items-center gap-2.5 flex-wrap">
          <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-semibold bg-white/10 backdrop-blur-md text-amber-300 border border-amber-400/30 uppercase tracking-widest shadow-sm">
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
            <?php echo htmlspecialchars($offerBadge); ?>
          </span>
          <?php if (!empty($offerDiscount)): ?>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-gradient-to-r from-amber-500 to-amber-600 text-neutral-950 uppercase tracking-wider shadow-md">
              <?php echo htmlspecialchars($offerDiscount); ?>
            </span>
          <?php endif; ?>
        </div>

        <!-- Main Headline -->
        <h1 class="text-3xl sm:text-5xl lg:text-5xl font-extrabold tracking-tight text-white leading-[1.15] font-serif">
          <?php echo htmlspecialchars($offerHeadline); ?>
        </h1>

        <!-- Subheadline / Terms -->
        <p class="text-sm sm:text-base text-neutral-200 leading-relaxed font-normal max-w-xl">
          <?php echo htmlspecialchars($offerSubheadline); ?>
        </p>

        <!-- Coupon Code Pill with 1-Click Copy -->
        <?php if (!empty($offerCoupon)): ?>
          <div class="inline-flex items-center gap-3 p-1.5 sm:p-2 bg-black/60 backdrop-blur-md rounded-2xl border border-gold/40 shadow-xl">
            <div class="flex items-center gap-2 pl-3">
              <span class="text-[10px] sm:text-xs font-bold text-gold uppercase tracking-wider">Coupon Code:</span>
              <span class="font-mono font-black text-sm sm:text-base text-white tracking-widest bg-white/10 px-2.5 py-0.5 rounded border border-white/10" id="heroOfferCouponText"><?php echo htmlspecialchars($offerCoupon); ?></span>
            </div>
            <button 
              type="button" 
              class="btn-copy-coupon bg-gold hover:bg-[#b08b42] text-neutral-950 font-extrabold text-xs px-3.5 py-1.5 rounded-xl transition inline-flex items-center gap-1.5 shadow" 
              onclick="copyOfferCode('<?php echo htmlspecialchars($offerCoupon); ?>', this)"
              title="Copy Coupon Code"
            >
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
              <span>Copy</span>
            </button>
          </div>
        <?php endif; ?>

        <!-- Live Countdown Timer -->
        <?php if ($offerCountdownEnabled && !empty($offerEndDate)): ?>
          <div class="offer-countdown-wrap pt-1" data-countdown-end="<?php echo htmlspecialchars($offerEndDate); ?>">
            <div class="text-[11px] font-bold text-amber-300 uppercase tracking-widest mb-2 flex items-center gap-1.5">
              <svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="animation-duration: 4s;"><circle cx="12" cy="12" r="10" stroke-width="2" stroke-dasharray="32" stroke-linecap="round"/></svg>
              <span><?php echo htmlspecialchars($offerCountdownLabel); ?></span>
            </div>
            <div class="flex items-center gap-2 sm:gap-3">
              <div class="countdown-card bg-neutral-900/85 backdrop-blur-md border border-gold/40 rounded-xl px-3 sm:px-4 py-2 text-center min-w-[58px] sm:min-w-[68px]">
                <span class="countdown-val text-xl sm:text-2xl font-black font-mono text-white block leading-none" data-cd-days>00</span>
                <span class="text-[9px] sm:text-[10px] font-bold text-gold uppercase tracking-wider block mt-1">Days</span>
              </div>
              <span class="text-gold font-bold text-lg leading-none">:</span>
              <div class="countdown-card bg-neutral-900/85 backdrop-blur-md border border-gold/40 rounded-xl px-3 sm:px-4 py-2 text-center min-w-[58px] sm:min-w-[68px]">
                <span class="countdown-val text-xl sm:text-2xl font-black font-mono text-white block leading-none" data-cd-hours>00</span>
                <span class="text-[9px] sm:text-[10px] font-bold text-gold uppercase tracking-wider block mt-1">Hours</span>
              </div>
              <span class="text-gold font-bold text-lg leading-none">:</span>
              <div class="countdown-card bg-neutral-900/85 backdrop-blur-md border border-gold/40 rounded-xl px-3 sm:px-4 py-2 text-center min-w-[58px] sm:min-w-[68px]">
                <span class="countdown-val text-xl sm:text-2xl font-black font-mono text-white block leading-none" data-cd-mins>00</span>
                <span class="text-[9px] sm:text-[10px] font-bold text-gold uppercase tracking-wider block mt-1">Mins</span>
              </div>
              <span class="text-gold font-bold text-lg leading-none">:</span>
              <div class="countdown-card bg-neutral-900/85 backdrop-blur-md border border-gold/40 rounded-xl px-3 sm:px-4 py-2 text-center min-w-[58px] sm:min-w-[68px]">
                <span class="countdown-val text-xl sm:text-2xl font-black font-mono text-amber-400 block leading-none" data-cd-secs>00</span>
                <span class="text-[9px] sm:text-[10px] font-bold text-gold uppercase tracking-wider block mt-1">Secs</span>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <!-- Key Offer Perks (Checklist) -->
        <?php if (!empty($offerPerks)): ?>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-neutral-200 pt-1">
            <?php foreach ($offerPerks as $perk): ?>
              <div class="flex items-center gap-2">
                <span class="w-4 h-4 rounded-full bg-gold/25 text-gold flex items-center justify-center font-bold text-[10px] flex-shrink-0 border border-gold/50">✓</span>
                <span class="font-medium text-neutral-100"><?php echo htmlspecialchars($perk); ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- Action CTA Buttons -->
        <div class="pt-2 flex flex-wrap gap-4">
          <a href="<?php echo htmlspecialchars($offerBtn1Link); ?>" target="_blank" class="bg-[#25D366] hover:bg-[#20ba5a] text-white px-7 py-3.5 rounded-full text-xs sm:text-sm font-bold tracking-wide transition shadow-lg inline-flex items-center gap-2 group">
            <svg class="w-4 h-4 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
            <span><?php echo htmlspecialchars($offerBtn1Text); ?></span>
          </a>
          <a href="<?php echo htmlspecialchars($offerBtn2Link); ?>" class="bg-white/10 hover:bg-white text-white hover:text-neutral-900 border border-white/30 hover:border-white px-7 py-3.5 rounded-full text-xs sm:text-sm font-bold tracking-wide transition shadow-lg inline-flex items-center gap-2 backdrop-blur-md">
            <span><?php echo htmlspecialchars($offerBtn2Text); ?></span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
          </a>
        </div>

      </div>

      <!-- Right Column: Glassmorphic Deal Spotlight Card -->
      <?php if ($offerCardEnabled): ?>
        <div class="hidden lg:flex lg:col-span-5 justify-center">
          <div class="hero-deal-card w-full max-w-sm bg-neutral-950/80 backdrop-blur-xl border border-gold/40 rounded-3xl p-6 relative text-white">
            
            <!-- Floating Badge -->
            <div class="absolute -top-3 -right-3 z-20">
              <span class="inline-block bg-gradient-to-r from-amber-500 to-amber-600 text-neutral-950 text-[11px] font-black uppercase tracking-wider px-3.5 py-1 rounded-full shadow-lg border border-amber-300">
                <?php echo htmlspecialchars($offerCardBadge); ?>
              </span>
            </div>

            <!-- Spotlight Image Container -->
            <div class="relative w-full h-52 bg-white/5 rounded-2xl overflow-hidden border border-white/10 p-3 mb-4 flex items-center justify-center group">
              <img 
                src="<?php echo htmlspecialchars($offerFeaturedImage); ?>" 
                alt="<?php echo htmlspecialchars($offerCardTitle); ?>" 
                class="max-h-full max-w-full object-contain drop-shadow-2xl group-hover:scale-105 transition-transform duration-500"
              >
            </div>

            <!-- Deal Details -->
            <div class="space-y-2">
              <span class="text-[10px] font-bold text-gold uppercase tracking-widest block">Featured Deal Spotlight</span>
              <h3 class="text-base font-bold text-white line-clamp-1">
                <?php echo htmlspecialchars($offerCardTitle); ?>
              </h3>
              <p class="text-xs text-neutral-300 line-clamp-2">
                <?php echo htmlspecialchars($offerCardSubtitle); ?>
              </p>

              <!-- Pricing & MOQ -->
              <div class="pt-2 flex items-baseline justify-between border-t border-white/10 mt-3">
                <div class="flex items-baseline gap-2">
                  <span class="text-xl font-extrabold text-amber-400 font-mono">
                    ₹<?php echo htmlspecialchars($offerCardPrice); ?>
                  </span>
                  <?php if (!empty($offerCardOrigPrice)): ?>
                    <span class="text-xs text-neutral-400 line-through font-mono">
                      ₹<?php echo htmlspecialchars($offerCardOrigPrice); ?>
                    </span>
                  <?php endif; ?>
                </div>
                <span class="text-[11px] font-semibold text-neutral-300 bg-white/10 px-2.5 py-0.5 rounded-full border border-white/10">
                  MOQ: <?php echo htmlspecialchars($offerCardMoq); ?>
                </span>
              </div>

              <!-- Quick Inquiry CTA -->
              <div class="pt-3">
                <?php 
                $dealInquiryMsg = "Hi Panna Heera Perfumes, I am interested in the featured offer on '" . $offerCardTitle . "' (Price: ₹" . $offerCardPrice . ") with offer code: " . $offerCoupon;
                ?>
                <a 
                  href="<?php echo getWhatsAppLink($dealInquiryMsg); ?>" 
                  target="_blank" 
                  class="w-full bg-gold hover:bg-[#b08b42] text-neutral-950 hover:text-white py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition text-center flex items-center justify-center gap-2 shadow"
                >
                  <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.954.815 2.796.815 3.183 0 5.768-2.586 5.768-5.766.001-3.182-2.584-5.767-5.768-5.767zm0 10.368c-.768 0-1.636-.242-2.316-.645l-.166-.098-1.579.414.421-1.539-.108-.172c-.443-.708-.677-1.488-.677-2.562 0-2.538 2.066-4.604 4.605-4.604 2.539 0 4.604 2.066 4.604 4.605 0 2.538-2.065 4.601-4.605 4.601z"/></svg>
                  <span>Inquire This Deal</span>
                </a>
              </div>

            </div>

          </div>
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>
