<?php
/**
 * Speed-Dial Floating Contact Widget
 * مدل‌سازی دقیق مطابق sazenomusic.com و با رنگ‌بندی تم رسمی سایت محمد مفتخری
 * کاملاً ایزوله با استایل‌های مستقیم (بدون وابستگی به پکت‌های پرج‌شده Tailwind)
 */
?>
<!-- استایل‌های اختصاصی و صددرصد تضمین‌شده ویجت شناور -->
<style>
#quick-contact-fab {
    position: fixed !important;
    bottom: 18px !important;
    right: 18px !important;
    z-index: 99999 !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    user-select: none !important;
    -webkit-user-select: none !important;
    direction: rtl !important;
}

@media (min-width: 640px) {
    #quick-contact-fab {
        bottom: 24px !important;
        right: 24px !important;
    }
}

/* دکمه اصلی (Trigger) */
.sazeno-master-btn {
    width: 54px !important;
    height: 54px !important;
    border-radius: 50% !important;
    background: #1B2B4A !important;
    border: 3px solid #38BDF8 !important;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4), 0 0 15px rgba(56, 189, 248, 0.35) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    outline: none !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative !important;
    padding: 0 !important;
}

.sazeno-master-btn:hover {
    transform: scale(1.08) !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5), 0 0 22px rgba(56, 189, 248, 0.6) !important;
}

.sazeno-master-btn:active {
    transform: scale(0.94) !important;
}

/* افکت رادار / پالس دکمه اصلی هنگام بسته بودن */
.sazeno-pulse-ring {
    position: absolute !important;
    top: -4px !important;
    left: -4px !important;
    right: -4px !important;
    bottom: -4px !important;
    border-radius: 50% !important;
    border: 2px solid #38BDF8 !important;
    opacity: 0.7 !important;
    animation: sazeno-pulse 2s infinite cubic-bezier(0.4, 0, 0.6, 1) !important;
    pointer-events: none !important;
}

@keyframes sazeno-pulse {
    0% {
        transform: scale(0.95);
        opacity: 0.8;
    }
    50% {
        transform: scale(1.22);
        opacity: 0;
    }
    100% {
        transform: scale(0.95);
        opacity: 0;
    }
}

/* لیست آیتم‌های عمودی شناور */
.sazeno-items-list {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    gap: 10px !important;
    margin-bottom: 12px !important;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
    transform-origin: bottom center !important;
    max-height: calc(100vh - 100px) !important;
    overflow-y: auto !important;
    scrollbar-width: none !important;
    -ms-overflow-style: none !important;
    padding: 4px !important;
}

.sazeno-items-list::-webkit-scrollbar {
    display: none !important;
}

/* حالت بسته بودن آیتم‌ها */
.sazeno-items-closed {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
    transform: translateY(18px) scale(0.7) !important;
}

/* حالت باز بودن آیتم‌ها */
.sazeno-items-open {
    opacity: 1 !important;
    visibility: visible !important;
    pointer-events: auto !important;
    transform: translateY(0) scale(1) !important;
}

/* هر دکمه فرعی ارتباطی */
.sazeno-sub-btn {
    width: 44px !important;
    height: 44px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    text-decoration: none !important;
    position: relative !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.2s ease !important;
    flex-shrink: 0 !important;
}

.sazeno-sub-btn:hover {
    transform: scale(1.12) !important;
}

.sazeno-sub-btn:active {
    transform: scale(0.95) !important;
}

/* استایل دقیق رنگ‌ها و حاشیه‌ها مطابق سازنو و تم سایت */
.btn-call {
    background: #E53935 !important;
    border: 2px solid #FFFFFF !important;
    box-shadow: 0 4px 14px rgba(229, 57, 53, 0.45) !important;
}

.btn-telegram {
    background: #229ED9 !important;
    border: 2px solid #38BDF8 !important;
    box-shadow: 0 4px 14px rgba(34, 158, 217, 0.45) !important;
}

.btn-bale-pv {
    background: #00A389 !important;
    border: 2px solid #FFFFFF !important;
    box-shadow: 0 4px 14px rgba(0, 163, 137, 0.45) !important;
}

.btn-bale-bot {
    background: #234063 !important;
    border: 2px solid #38BDF8 !important;
    box-shadow: 0 4px 14px rgba(35, 64, 99, 0.45) !important;
}

.btn-whatsapp {
    background: #25D366 !important;
    border: 2px solid #FFFFFF !important;
    box-shadow: 0 4px 14px rgba(37, 211, 102, 0.45) !important;
}

.btn-email {
    background: #EA4335 !important;
    border: 2px solid #FFFFFF !important;
    box-shadow: 0 4px 14px rgba(234, 67, 53, 0.45) !important;
}

.btn-booking {
    background: #1A2A44 !important;
    border: 2px solid #38BDF8 !important;
    box-shadow: 0 4px 14px rgba(26, 42, 68, 0.45) !important;
}

/* برچسب راهنما (Tooltip) */
.sazeno-tooltip {
    position: absolute !important;
    right: 56px !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    background: rgba(15, 23, 42, 0.95) !important;
    color: #FFFFFF !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    padding: 5px 10px !important;
    border-radius: 8px !important;
    white-space: nowrap !important;
    border: 1px solid rgba(56, 189, 248, 0.4) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4) !important;
    opacity: 0 !important;
    pointer-events: none !important;
    transition: opacity 0.2s ease, transform 0.2s ease !important;
    transform: translateY(-50%) translateX(6px) !important;
}

.sazeno-sub-btn:hover .sazeno-tooltip {
    opacity: 1 !important;
    transform: translateY(-50%) translateX(0) !important;
}

/* پس‌زمینه محو برای بستن */
#sazeno-backdrop {
    position: fixed !important;
    inset: 0 !important;
    z-index: 99998 !important;
    background: rgba(11, 17, 32, 0.35) !important;
    backdrop-filter: blur(2px) !important;
    -webkit-backdrop-filter: blur(2px) !important;
    opacity: 0 !important;
    pointer-events: none !important;
    transition: opacity 0.25s ease !important;
}

#sazeno-backdrop.active {
    opacity: 1 !important;
    pointer-events: auto !important;
}
</style>

<div id="quick-contact-fab" aria-label="راه‌های ارتباطی و تماس">
    
    <!-- ۱. لیست بازشونده دکمه‌های ارتباطی (عمودی به بالا) -->
    <div id="fab-actions-list" class="sazeno-items-list sazeno-items-closed" role="menu">
        
        <!-- ۱. تماس تلفنی مستقیم (قرمز با کادر سفید مانند سازنو) -->
        <a href="tel:09302928001" 
           class="sazeno-sub-btn btn-call" 
           title="تماس مستقیم: 09302928001" 
           aria-label="تماس تلفنی مستقیم">
            <!-- آیکون وکتور تلفن کامپکت و شفاف سفید -->
            <svg style="width: 20px; height: 20px; fill: #FFFFFF;" viewBox="0 0 24 24">
                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
            </svg>
            <span class="sazeno-tooltip">تماس مستقیم (۰۹۳۰۲۹۲۸۰۰۱)</span>
        </a>

        <!-- ۲. پیام مستقیم در تلگرام (آبی آسمانی با کادر فیروزه‌ای) -->
        <a href="https://t.me/maaad_mr" 
           target="_blank" 
           rel="noopener" 
           class="sazeno-sub-btn btn-telegram" 
           title="پیام در تلگرام: @maaad_mr" 
           aria-label="پیام در تلگرام">
            <svg style="width: 20px; height: 20px; fill: #FFFFFF;" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .37z"/>
            </svg>
            <span class="sazeno-tooltip">پیام تلگرام (@maaad_mr)</span>
        </a>

        <!-- ۳. پیام‌رسان بله (سبزآبی با کادر سفید مطابق سازنو) -->
        <a href="https://ble.ir/maaad_mr" 
           target="_blank" 
           rel="noopener" 
           class="sazeno-sub-btn btn-bale-pv" 
           title="پیام‌رسان بله: @maaad_mr" 
           aria-label="پیام‌رسان بله">
            <svg style="width: 22px; height: 22px; fill: #FFFFFF;" viewBox="54 4 32 32">
                <path d="M72.2139 4.1563C72.2051 4.15482 72.1962 4.15433 72.1878 4.15285C71.9482 4.12031 71.707 4.09171 71.464 4.06952C71.3821 4.06213 71.2993 4.0572 71.2169 4.05079C71.0409 4.03747 70.8649 4.02465 70.6869 4.01726C70.5631 4.01183 70.4383 4.01035 70.3141 4.00789C70.2091 4.00592 70.1055 4 70 4C69.9522 4 69.9043 4.00247 69.8565 4.00296C69.8235 4.00345 69.7909 4.00148 69.7579 4.00197C69.6864 4.00296 69.6159 4.0074 69.5449 4.00937C69.4423 4.01233 69.3393 4.01529 69.2367 4.01972C69.1253 4.02515 69.0148 4.03205 68.9039 4.03994C68.8018 4.04684 68.7002 4.05374 68.5987 4.06262C68.4882 4.07248 68.3787 4.08382 68.2688 4.09565C68.1687 4.1065 68.0681 4.11686 67.9685 4.12968C67.859 4.14348 67.7506 4.15975 67.6416 4.17553C67.5425 4.19032 67.4434 4.20413 67.3452 4.22089C67.2368 4.23914 67.1298 4.25935 67.0223 4.27957C66.9247 4.29781 66.827 4.31556 66.7304 4.33578C66.6229 4.35797 66.5169 4.38262 66.4104 4.40727C66.3147 4.42897 66.2191 4.45017 66.1244 4.47384C66.0174 4.50046 65.9119 4.52955 65.8059 4.55815C65.7127 4.5833 65.619 4.60795 65.5268 4.63458C65.4212 4.66515 65.3172 4.69818 65.2132 4.73122C65.1215 4.75982 65.0297 4.78792 64.9385 4.818C64.835 4.85251 64.7324 4.88998 64.6299 4.92647C64.5396 4.95852 64.4494 4.98958 64.3601 5.02311C64.2576 5.06206 64.156 5.10348 64.0539 5.14441C63.9671 5.17941 63.8794 5.21294 63.7931 5.24943C63.69 5.29282 63.589 5.33917 63.4874 5.38453C63.4036 5.422 63.3192 5.458 63.2359 5.49695C63.1343 5.54428 63.0342 5.59507 62.9337 5.64438C62.8528 5.68431 62.7709 5.72277 62.6906 5.76419C62.5895 5.81646 62.4899 5.87119 62.3903 5.92542C62.3124 5.96783 62.2335 6.00826 62.1566 6.05165C62.054 6.10934 61.9539 6.16998 61.8528 6.23014C61.7803 6.27304 61.7074 6.31445 61.6359 6.35834C61.5269 6.42539 61.4204 6.49541 61.3129 6.56493C61.2513 6.60487 60.6329 7.02743 60.6329 7.02743C60.6329 7.02743 57.7178 4.80616 56.5547 4.20018C55.3915 3.59421 54 4.43834 54 5.74989V8.70336V19.6933C54 19.7983 54 19.9014 54 20C54 28.4822 60.6014 35.4182 68.9463 35.9615C68.9946 35.965 69.0424 35.9694 69.0908 35.9724C69.251 35.9813 69.4127 35.9847 69.574 35.9892C69.6741 35.9921 69.7727 35.9985 69.8733 35.9995C69.8945 35.9995 69.9157 35.9985 69.9369 35.9985C69.9581 35.9985 69.9793 36 70.001 36C70.1213 36 70.2396 35.9936 70.3595 35.9911C70.4941 35.9882 70.6292 35.9872 70.7633 35.9808C70.9033 35.9744 71.0424 35.9625 71.1814 35.9522C71.3141 35.9423 71.4467 35.9349 71.5784 35.9221C71.7164 35.9088 71.853 35.8896 71.9901 35.8728C72.1207 35.8565 72.2524 35.8422 72.3826 35.823C72.5182 35.8028 72.6518 35.7771 72.7864 35.754C72.9156 35.7313 73.0448 35.7106 73.173 35.6849C73.3071 35.6578 73.4392 35.6258 73.5719 35.5957C73.6981 35.5671 73.8248 35.54 73.9496 35.5084C74.0812 35.4749 74.2109 35.4364 74.3411 35.3999C74.4649 35.3649 74.5891 35.3324 74.7114 35.2949C74.8406 35.255 74.9673 35.2106 75.095 35.1677C75.2158 35.1273 75.3381 35.0883 75.4574 35.0449C75.5837 34.9991 75.7074 34.9488 75.8322 34.9C75.9505 34.8536 76.0698 34.8092 76.1872 34.7599C76.3105 34.7082 76.4313 34.652 76.5526 34.5972C76.6679 34.5455 76.7843 34.4957 76.8982 34.4409C77.018 34.3837 77.1354 34.3216 77.2532 34.2614C77.3661 34.2038 77.48 34.1485 77.591 34.0884C77.7069 34.0258 77.8198 33.9587 77.9337 33.8936C78.0436 33.8305 78.1551 33.7694 78.2636 33.7038C78.3765 33.6357 78.4864 33.5633 78.5974 33.4923C78.7034 33.4247 78.8109 33.3586 78.9154 33.2886C79.0249 33.2152 79.1309 33.1373 79.2384 33.0608C79.3409 32.9884 79.4445 32.9173 79.5451 32.8429C79.6506 32.764 79.7531 32.6812 79.8567 32.6003C79.9553 32.5229 80.0549 32.448 80.1516 32.3686C80.2541 32.2843 80.3532 32.196 80.4533 32.1092C80.547 32.0284 80.6427 31.949 80.7344 31.8656C80.833 31.7764 80.9282 31.6827 81.0248 31.591C81.1141 31.5062 81.2053 31.4229 81.2925 31.3356C81.3867 31.2414 81.4775 31.1438 81.5692 31.0471C81.6545 30.9579 81.7413 30.8706 81.8246 30.7794C81.9143 30.6808 82.0001 30.5787 82.0874 30.4777C82.1683 30.3845 82.2511 30.2933 82.3295 30.1981C82.4143 30.096 82.4947 29.99 82.5765 29.8855C82.6535 29.7879 82.7323 29.6922 82.8068 29.5926C82.8862 29.4866 82.9611 29.3771 83.0381 29.2692C83.1105 29.1676 83.185 29.0675 83.2545 28.9644C83.3295 28.854 83.3995 28.7401 83.472 28.6277C83.539 28.5231 83.6081 28.4206 83.6727 28.3146C83.7422 28.2007 83.8068 28.0833 83.8738 27.967C83.936 27.859 84.0006 27.7525 84.0602 27.643C84.1248 27.5237 84.185 27.4019 84.2466 27.2806C84.3028 27.1712 84.361 27.0632 84.4147 26.9522C84.4749 26.828 84.5291 26.7008 84.5863 26.575C84.6366 26.4641 84.6894 26.3541 84.7367 26.2417C84.791 26.1135 84.8398 25.9824 84.8911 25.8527C84.9354 25.7398 84.9828 25.6284 84.0247 25.514C85.0735 25.3813 85.1164 25.2457 85.1618 25.1111C85.2002 24.9967 85.2416 24.8843 85.2776 24.7689C85.3205 24.6314 85.3575 24.4913 85.3965 24.3523C85.429 24.2374 85.4645 24.124 85.4941 24.0081C85.5311 23.8656 85.5612 23.7212 85.5942 23.5772C85.6203 23.4618 85.6499 23.3484 85.6736 23.232C85.7042 23.0841 85.7278 22.9342 85.754 22.7848C85.7742 22.6704 85.7973 22.5575 85.8151 22.4427C85.8393 22.2854 85.8565 22.1261 85.8757 21.9678C85.8891 21.8584 85.9063 21.7504 85.9172 21.6399C85.9354 21.4619 85.9463 21.2815 85.9581 21.1015C85.9645 21.0093 85.9744 20.9181 85.9793 20.8254C85.9926 20.5665 85.9985 20.3057 85.999 20.0434C85.999 20.0291 86 20.0148 86 20C86.001 11.9152 80.0026 5.23464 72.2139 4.1563ZM79.3404 17.9528L70.0503 27.2431C69.4404 27.8526 68.6416 28.1573 67.8423 28.1573C67.043 28.1573 66.2442 27.8526 65.6343 27.2431L60.6605 22.2691C59.4412 21.0497 59.4412 19.073 60.6605 17.8537C61.8799 16.6348 63.8567 16.6348 65.0761 17.8537L67.8428 20.6203L74.9254 13.5374C76.1448 12.3185 78.1215 12.3185 79.3409 13.5374C80.5598 14.7572 80.5598 16.7334 79.3404 17.9528Z"/>
            </svg>
            <span class="sazeno-tooltip">پیام در بله (@maaad_mr)</span>
        </a>

        <!-- ۴. بازوی هوشمند بله (سرمه‌ای با کادر فیروزه‌ای مطابق سازنو) -->
        <a href="https://ble.ir/maaad_mrbot" 
           target="_blank" 
           rel="noopener" 
           class="sazeno-sub-btn btn-bale-bot" 
           title="بازوی هوشمند بله: @maaad_mrbot" 
           aria-label="بازوی بله">
            <svg style="width: 20px; height: 20px; fill: #FFFFFF;" viewBox="0 0 24 24">
                <path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2M7.5 13A2.5 2.5 0 0 0 5 15.5 2.5 2.5 0 0 0 7.5 18a2.5 2.5 0 0 0 2.5-2.5A2.5 2.5 0 0 0 7.5 13m9 0a2.5 2.5 0 0 0-2.5 2.5 2.5 2.5 0 0 0 2.5 2.5 2.5 2.5 0 0 0 2.5-2.5 2.5 2.5 0 0 0-2.5-2.5"/>
            </svg>
            <span class="sazeno-tooltip">بازوی هوشمند بله (@maaad_mrbot)</span>
        </a>

        <!-- ۵. واتساپ (سبز رسمی واتساپ با کادر سفید) -->
        <a href="https://wa.me/989302928001" 
           target="_blank" 
           rel="noopener" 
           class="sazeno-sub-btn btn-whatsapp" 
           title="ارتباط در واتساپ: 09302928001" 
           aria-label="پیام در واتساپ">
            <svg style="width: 21px; height: 21px; fill: #FFFFFF;" viewBox="0 0 24 24">
                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 01-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24M8.53 7.33c-.16 0-.42.06-.64.3-.22.24-.85.83-.85 2.03 0 1.2.88 2.36 1 2.53.12.16 1.7 2.6 4.13 3.65.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.47-.07 1.44-.59 1.64-1.16.2-.57.2-1.06.14-1.16-.06-.1-.22-.16-.47-.28-.25-.13-1.44-.71-1.66-.79-.22-.09-.39-.13-.55.13-.16.25-.63.79-.77.95-.14.16-.28.18-.53.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.26-1.5-1.41-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.38-.44.12-.14.16-.25.25-.41.08-.16.04-.31-.02-.44-.06-.12-.55-1.33-.76-1.82-.2-.48-.41-.41-.56-.42-.14-.01-.31-.01-.48-.01z"/>
            </svg>
            <span class="sazeno-tooltip">واتساپ (۰۹۳۰۲۹۲۸۰۰۱)</span>
        </a>

        <!-- ۶. ایمیل مستقیم (قرمز مرجانی با کادر سفید) -->
        <a href="mailto:mohammad@maaadmr.ir" 
           class="sazeno-sub-btn btn-email" 
           title="ارسال ایمیل: mohammad@maaadmr.ir" 
           aria-label="ارسال ایمیل">
            <svg style="width: 20px; height: 20px; fill: #FFFFFF;" viewBox="0 0 24 24">
                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
            <span class="sazeno-tooltip">ارسال ایمیل (mohammad@maaadmr.ir)</span>
        </a>

        <!-- ۷. رزرو جلسه و ثبت پروژه (سرمه‌ای متالیک با کادر فیروزه‌ای) -->
        <a href="/start" 
           class="sazeno-sub-btn btn-booking" 
           title="رزرو نوبت مشاوره سئو" 
           aria-label="رزرو نوبت مشاوره">
            <svg style="width: 20px; height: 20px; fill: #FFFFFF;" viewBox="0 0 24 24">
                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
            </svg>
            <span class="sazeno-tooltip">رزرو نوبت مشاوره سئو</span>
        </a>

    </div>

    <!-- ۲. دکمه اصلی شناور (Master Button - دقیقاً شبیه سازنو) -->
    <button id="sazeno-master-btn" 
            type="button" 
            onclick="toggleSpeedDialFab()" 
            class="sazeno-master-btn" 
            aria-expanded="false" 
            aria-label="راه‌های ارتباطی و تماس سریع">
        
        <!-- حلقه پالس ملایم فیروزه‌ای -->
        <span id="sazeno-pulse" class="sazeno-pulse-ring"></span>

        <!-- آیکون ۱: گوشی تلفن سفید (در حالت بسته بودن، دقیقاً مثل سازنو) -->
        <span id="sazeno-phone-icon" style="display: flex; align-items: center; justify-content: center; transition: all 0.25s ease;">
            <svg style="width: 26px; height: 26px; fill: #FFFFFF;" viewBox="0 0 24 24">
                <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 0 0-1.01.24l-2.2 2.2a15.05 15.05 0 0 1-6.59-6.59l2.2-2.21a.96.96 0 0 0 .25-1.01A11.36 11.36 0 0 1 8.5 3.93c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-.99-1.05z"/>
            </svg>
        </span>

        <!-- آیکون ۲: ضربدر سفید 'X' (در حالت باز بودن) -->
        <span id="sazeno-close-icon" style="display: none; align-items: center; justify-content: center; transition: all 0.25s ease;">
            <svg style="width: 24px; height: 24px; fill: #FFFFFF;" viewBox="0 0 24 24">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
            </svg>
        </span>
    </button>
</div>

<!-- بک‌دراپ کم‌رنگ برای کلیک خارج از منو و بسته شدن -->
<div id="sazeno-backdrop" onclick="toggleSpeedDialFab(false)"></div>

<script>
(function() {
    let isOpen = false;
    const actionsList = document.getElementById('fab-actions-list');
    const masterBtn = document.getElementById('sazeno-master-btn');
    const phoneIcon = document.getElementById('sazeno-phone-icon');
    const closeIcon = document.getElementById('sazeno-close-icon');
    const pulseRing = document.getElementById('sazeno-pulse');
    const backdrop = document.getElementById('sazeno-backdrop');

    window.toggleSpeedDialFab = function(forceState) {
        if (typeof forceState === 'boolean') {
            isOpen = forceState;
        } else {
            isOpen = !isOpen;
        }

        if (isOpen) {
            // نمایش آیتم‌ها به سمت بالا
            actionsList.classList.remove('sazeno-items-closed');
            actionsList.classList.add('sazeno-items-open');
            
            // تغییر آیکون به ضربدر و انیمیشن چرخش
            phoneIcon.style.display = 'none';
            closeIcon.style.display = 'flex';
            if (pulseRing) pulseRing.style.display = 'none';
            masterBtn.style.transform = 'rotate(90deg)';
            masterBtn.setAttribute('aria-expanded', 'true');

            // نمایش بک‌دراپ
            if (backdrop) backdrop.classList.add('active');
        } else {
            // جمع شدن آیتم‌ها
            actionsList.classList.remove('sazeno-items-open');
            actionsList.classList.add('sazeno-items-closed');

            // بازگشت به آیکون تلفن
            phoneIcon.style.display = 'flex';
            closeIcon.style.display = 'none';
            if (pulseRing) pulseRing.style.display = 'block';
            masterBtn.style.transform = 'rotate(0deg)';
            masterBtn.setAttribute('aria-expanded', 'false');

            // بستن بک‌دراپ
            if (backdrop) backdrop.classList.remove('active');
        }
    };

    // بستن با کلید Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isOpen) {
            toggleSpeedDialFab(false);
        }
    });
})();
</script>
