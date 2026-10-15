<?php
/**
 * Smart Sales Assistant Chat Widget (Powered by Gemini AI)
 * Mohammad Moftakhari CMS (maaadmr.ir)
 * Mobile-First, RTL, Tailwind CSS, Vanilla JS
 */
?>
<!-- Chat Widget Container -->
<div id="ai-sales-chat-widget" class="fixed bottom-4 right-4 z-50 select-none font-sans" dir="rtl">

    <!-- 1. Floating Pop-up Tooltip (Appears after 5 seconds) -->
    <div id="chat-popup-tooltip" 
         class="hidden absolute bottom-16 right-0 mb-2 w-max max-w-[260px] bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 text-xs sm:text-sm font-medium py-2.5 px-3.5 rounded-2xl shadow-xl border border-blue-500/30 flex items-center gap-2.5 transition-all duration-300 transform translate-y-2 opacity-0 z-50">
        <span class="cursor-pointer flex items-center gap-1.5" onclick="toggleChatWindow(true)">
            <span>نیاز به مشاوره دارید؟ 🚀</span>
        </span>
        <button type="button" 
                onclick="dismissTooltip(event)" 
                class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors p-0.5 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700" 
                aria-label="بستن اعلان">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <!-- Triangle tail -->
        <div class="absolute -bottom-1.5 right-6 w-3 h-3 bg-white dark:bg-slate-800 border-b border-l border-blue-500/30 transform -rotate-45"></div>
    </div>

    <!-- 2. Floating Action Button with Attention-Grabbing Pulse / Bounce -->
    <button id="chat-toggle-btn"
            type="button"
            onclick="toggleChatWindow()"
            class="relative group w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-tr from-blue-600 via-indigo-600 to-cyan-500 text-white shadow-2xl shadow-blue-500/50 flex items-center justify-center transition-all duration-300 hover:scale-105 active:scale-95 focus:outline-none"
            aria-label="گفتگو با دستیار هوشمند">
        
        <!-- Ripple / Pulse Waves -->
        <span class="absolute -inset-1 rounded-full bg-gradient-to-tr from-blue-600 to-cyan-500 opacity-60 animate-ping pointer-events-none"></span>
        <span class="absolute -inset-0.5 rounded-full bg-blue-500 opacity-40 blur-sm group-hover:opacity-80 transition duration-300"></span>

        <!-- Chat Icon (Default Visible) -->
        <span id="chat-icon-open" class="relative z-10 flex items-center justify-center transition-transform duration-300 group-hover:rotate-6">
            <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        </span>

        <!-- Close Icon (When Chat Window is Open) -->
        <span id="chat-icon-close" class="hidden relative z-10">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </span>

        <!-- Online Green Status Indicator Dot -->
        <span class="absolute top-0 right-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-white dark:border-slate-900 rounded-full z-20 shadow-sm"></span>
    </button>

    <!-- 3. Mobile-First Chat Window -->
    <div id="chat-window"
         class="hidden fixed bottom-0 right-0 w-full h-[85vh] rounded-t-3xl shadow-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 md:bottom-20 md:right-6 md:w-[380px] md:h-[600px] md:rounded-2xl flex-col overflow-hidden z-50 transition-all duration-300 ease-out">
        
        <!-- Premium Header -->
        <div class="px-4 py-3.5 bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 text-white flex items-center justify-between shrink-0 shadow-md">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-lg shadow-inner">
                        🤖
                    </div>
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-400 rounded-full ring-2 ring-blue-800"></span>
                </div>
                <div>
                    <h3 class="text-sm font-bold tracking-tight text-white flex items-center gap-1.5">
                        <span>دستیار هوشمند محمد مفتخری</span>
                        <span class="text-[10px] font-normal bg-blue-500/40 text-blue-100 px-1.5 py-0.5 rounded-full border border-blue-400/30">AI</span>
                    </h3>
                    <div class="flex items-center gap-2 text-[11px] text-blue-200">
                        <div class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>آنلاین</span>
                        </div>
                        <span class="text-blue-300 text-[10px]">•</span>
                        <span id="chat-counter-badge" class="text-[10px] bg-white/20 text-blue-100 px-2 py-0.5 rounded-full font-medium">
                            <span id="chat-messages-left">۶</span> پیام باقی‌مانده
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-1">
                <!-- Reset Chat Button -->
                <button type="button" 
                        onclick="resetChatHistory()" 
                        title="شروع گفتگوی جدید"
                        class="text-blue-200 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition-colors"
                        aria-label="شروع گفتگوی جدید">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
                <!-- Close Window Button -->
                <button type="button" 
                        onclick="toggleChatWindow(false)" 
                        class="text-blue-200 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition-colors"
                        aria-label="بستن چت">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Scrollable Messages Container -->
        <div id="chat-messages" 
             class="flex-1 p-4 overflow-y-auto space-y-3.5 bg-slate-50/60 dark:bg-slate-900/60 text-xs sm:text-sm select-text">
            
            <!-- Bot Initial Greeting -->
            <div class="flex items-start gap-2 max-w-[90%]">
                <div class="w-7 h-7 rounded-full bg-blue-600/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 text-sm mt-0.5 border border-blue-500/20">
                    🤖
                </div>
                <div class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 p-3.5 rounded-2xl rounded-tr-none shadow-sm border border-slate-200/80 dark:border-slate-700/80 leading-relaxed space-y-2">
                    <p>
                        سلام! 👋 من دستیار هوشمند و ۲۴ ساعته <strong>محمد مفتخری</strong> هستم.
                    </p>
                    <p class="text-[12px] text-slate-600 dark:text-slate-300">
                        در زمینه استراتژی سئو، اتوماسیون محتوا با هوش مصنوعی، بهینه‌سازی سرعت و افزایش نرخ تبدیل چه سوالی دارید؟
                    </p>
                </div>
            </div>

            <!-- Quick Suggestion Chips -->
            <div id="chat-suggestion-chips" class="flex flex-wrap gap-1.5 pr-9">
                <button type="button" 
                        onclick="sendQuickPrompt('از کجا سئو سایتم رو شروع کنم و نقشه راه چیه؟')"
                        class="bg-white dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-slate-700 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-slate-700 px-2.5 py-1.5 rounded-xl text-[11px] font-medium transition-all shadow-xs hover:border-blue-400">
                    🧭 نقشه راه سئو
                </button>
                <button type="button" 
                        onclick="sendQuickPrompt('فروش و لید سایتم پایینه، چطور با CRO درستش کنم؟')"
                        class="bg-white dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-slate-700 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-slate-700 px-2.5 py-1.5 rounded-xl text-[11px] font-medium transition-all shadow-xs hover:border-blue-400">
                    📈 افزایش فروش (CRO)
                </button>
                <button type="button" 
                        onclick="sendQuickPrompt('سرعت سایتم کنده و ارورهای تکنیکال دارم')"
                        class="bg-white dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-slate-700 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-slate-700 px-2.5 py-1.5 rounded-xl text-[11px] font-medium transition-all shadow-xs hover:border-blue-400">
                    ⚡ سئوی تکنیکال و سرعت
                </button>
                <button type="button" 
                        onclick="sendQuickPrompt('سئو محلی و رتبه اول گوگل مپ چطور انجام میشه؟')"
                        class="bg-white dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-slate-700 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-slate-700 px-2.5 py-1.5 rounded-xl text-[11px] font-medium transition-all shadow-xs hover:border-blue-400">
                    📍 سئوی محلی و مپ
                </button>
            </div>

            <!-- Typing Indicator (Hidden by default) -->
            <div id="chat-typing-indicator" class="hidden items-center gap-2 max-w-[80%] pr-1">
                <div class="w-6 h-6 rounded-full bg-blue-600/10 text-blue-600 flex items-center justify-center text-xs shrink-0">
                    🤖
                </div>
                <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 py-2 px-3.5 rounded-2xl rounded-tr-none flex items-center gap-1.5 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-bounce"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-bounce [animation-delay:0.2s]"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-bounce [animation-delay:0.4s]"></span>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 mr-1.5">در حال پردازش...</span>
                </div>
            </div>

        </div>

        <!-- Chat Input Form -->
        <form id="chat-form" onsubmit="handleChatSubmit(event)" class="p-3 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex items-center gap-2 shrink-0">
            <input type="text" 
                   id="chat-user-input"
                   placeholder="سؤالتان را بپرسید..." 
                   autocomplete="off"
                   maxlength="400"
                   class="flex-1 px-3.5 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder-slate-400 text-xs sm:text-sm rounded-xl border border-transparent focus:border-blue-500 focus:bg-white dark:focus:bg-slate-800 focus:outline-none transition-all">
            
            <button type="submit" 
                    id="chat-send-btn"
                    class="w-10 h-10 rounded-xl bg-blue-600 hover:bg-blue-700 active:scale-95 text-white flex items-center justify-center shrink-0 transition-all shadow-md shadow-blue-500/20 disabled:opacity-50 disabled:cursor-not-allowed"
                    aria-label="ارسال پیام">
                <svg class="w-4 h-4 transform -rotate-90 rtl:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </button>
        </form>

        <!-- Conversational Limit Reached CTA Container (Appears after 6 messages) -->
        <div id="chat-limit-container" class="hidden p-3 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-800/90 border-t border-slate-200 dark:border-slate-700 text-center space-y-2 shrink-0">
            <div class="text-[11px] font-bold text-slate-700 dark:text-slate-200 flex items-center justify-center gap-1.5">
                <span>🔒</span>
                <span>سقف مشاوره آنلاین این جلسه تکمیل شد (۶ از ۶ پیام)</span>
            </div>
            <a href="/start" class="block w-full py-2.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl text-xs shadow-md transition-all">
                ثبت فرم شروع همکاری و مشاوره اختصاصی 🚀
            </a>
            <div class="text-[10px] text-slate-500 dark:text-slate-400">
                یا تماس مستقیم: <a href="tel:09120638548" class="font-bold text-blue-600 dark:text-blue-400 underline">09120638548</a>
            </div>
        </div>

        <!-- Footer Notice -->
        <div class="px-3 py-1 bg-slate-100/70 dark:bg-slate-950/70 text-[10px] text-center text-slate-400 dark:text-slate-500">
            پاسخ‌ها توسط هوش مصنوعی محمد مفتخری تولید می‌شوند
        </div>
    </div>
</div>

<!-- Chat Widget Client Logic -->
<script>
(function() {
    const tooltip = document.getElementById('chat-popup-tooltip');
    const chatWindow = document.getElementById('chat-window');
    const toggleBtn = document.getElementById('chat-toggle-btn');
    const iconOpen = document.getElementById('chat-icon-open');
    const iconClose = document.getElementById('chat-icon-close');
    const messagesBox = document.getElementById('chat-messages');
    const typingIndicator = document.getElementById('chat-typing-indicator');
    const userInput = document.getElementById('chat-user-input');
    const sendBtn = document.getElementById('chat-send-btn');

    let isWindowOpen = false;
    let isWaitingResponse = false;

    // 1. Tooltip Timer: Appears after 5 seconds
    window.addEventListener('DOMContentLoaded', () => {
        const tooltipDismissed = sessionStorage.getItem('ai_chat_tooltip_dismissed');
        if (!tooltipDismissed) {
            setTimeout(() => {
                if (!isWindowOpen && tooltip) {
                    tooltip.classList.remove('hidden');
                    // Smooth fade & slide in
                    setTimeout(() => {
                        tooltip.classList.remove('opacity-0', 'translate-y-2');
                    }, 50);
                }
            }, 5000);
        }
    });

    window.dismissTooltip = function(e) {
        if (e) e.stopPropagation();
        if (tooltip) {
            tooltip.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => {
                tooltip.classList.add('hidden');
            }, 300);
            sessionStorage.setItem('ai_chat_tooltip_dismissed', '1');
        }
    };

    // 2. Open / Close Chat Window
    window.toggleChatWindow = function(forceOpen = null) {
        if (forceOpen !== null) {
            isWindowOpen = forceOpen;
        } else {
            isWindowOpen = !isWindowOpen;
        }

        if (isWindowOpen) {
            dismissTooltip();
            chatWindow.classList.remove('hidden');
            chatWindow.classList.add('flex');
            iconOpen.classList.add('hidden');
            iconClose.classList.remove('hidden');
            toggleBtn.classList.remove('animate-bounce');
            // Auto-focus input on desktop
            if (window.innerWidth >= 768) {
                setTimeout(() => userInput.focus(), 200);
            }
            scrollToBottom();
        } else {
            chatWindow.classList.add('hidden');
            chatWindow.classList.remove('flex');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
        }
    };

    // 3. Scroll to Bottom Helper
    function scrollToBottom() {
        if (messagesBox) {
            messagesBox.scrollTop = messagesBox.scrollHeight;
        }
    }

    // 4. Quick Suggestion Prompts
    window.sendQuickPrompt = function(text) {
        if (isWaitingResponse) return;
        userInput.value = text;
        handleChatSubmit(new Event('submit'));
    };

    // 5. Submit Message to Backend
    window.handleChatSubmit = async function(e) {
        if (e) e.preventDefault();
        const message = userInput.value.trim();
        if (!message || isWaitingResponse) return;

        // Append User Message to UI
        appendUserMessage(message);
        userInput.value = '';
        isWaitingResponse = true;
        sendBtn.disabled = true;
        userInput.disabled = true;

        // Hide Suggestion Chips after first interaction
        const chips = document.getElementById('chat-suggestion-chips');
        if (chips) chips.classList.add('hidden');

        // Show Typing Indicator
        showTyping(true);
        scrollToBottom();

        try {
            const res = await fetch('/api/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await res.json();
            showTyping(false);

            if (data && data.success && data.reply) {
                appendBotMessage(data.reply);

                // Update counter and check limit status
                if (typeof data.messages_left !== 'undefined') {
                    updateMessageCounter(data.messages_left, data.limit_reached);
                }
            } else {
                appendBotMessage(data.error || 'متأسفانه در حال حاضر خطایی رخ داد. لطفاً با <a href="/contact" class="text-blue-500 font-bold underline">پشتیبانی</a> در ارتباط باشید.');
                if (data && data.limit_reached) {
                    updateMessageCounter(0, true);
                }
            }
        } catch (err) {
            showTyping(false);
            appendBotMessage('خطا در برقراری ارتباط با سرور. لطفاً اتصال اینترنت خود را بررسی کرده و مجدداً تلاش فرمایید.');
        } finally {
            isWaitingResponse = false;
            sendBtn.disabled = false;
            userInput.disabled = false;
            scrollToBottom();
            if (window.innerWidth >= 768) {
                userInput.focus();
            }
        }
    };

    // 6. UI Append & Counter Helpers
    function updateMessageCounter(left, isLimit) {
        const counterEl = document.getElementById('chat-messages-left');
        const badgeEl = document.getElementById('chat-counter-badge');
        const formEl = document.getElementById('chat-form');
        const limitBox = document.getElementById('chat-limit-container');

        if (counterEl) {
            counterEl.textContent = Math.max(0, left);
        }

        if (isLimit || left <= 0) {
            if (badgeEl) {
                badgeEl.className = 'text-[10px] bg-rose-500/40 text-rose-100 px-2 py-0.5 rounded-full font-bold';
                badgeEl.textContent = 'سقف تکمیل شد';
            }
            if (formEl) formEl.classList.add('hidden');
            if (limitBox) limitBox.classList.remove('hidden');
        } else if (left === 1) {
            if (badgeEl) {
                badgeEl.className = 'text-[10px] bg-amber-500/40 text-amber-100 px-2 py-0.5 rounded-full font-medium';
            }
        }
    }

    function appendUserMessage(text) {
        const div = document.createElement('div');
        div.className = 'flex items-end justify-end max-w-[85%] mr-auto';
        
        // Escape HTML for user input to prevent XSS
        const safeText = document.createElement('div');
        safeText.textContent = text;

        div.innerHTML = `
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-3 rounded-2xl rounded-tl-none shadow-sm leading-relaxed text-xs sm:text-sm">
                ${safeText.innerHTML}
            </div>
        `;
        messagesBox.insertBefore(div, typingIndicator);
        scrollToBottom();
    }

    function appendBotMessage(htmlContent) {
        const div = document.createElement('div');
        div.className = 'flex items-start gap-2 max-w-[90%]';
        div.innerHTML = `
            <div class="w-6 h-6 rounded-full bg-blue-600/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 text-xs mt-0.5 border border-blue-500/20">
                🤖
            </div>
            <div class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 p-3.5 rounded-2xl rounded-tr-none shadow-sm border border-slate-200/80 dark:border-slate-700/80 leading-relaxed text-xs sm:text-sm space-y-2">
                ${htmlContent}
            </div>
        `;
        messagesBox.insertBefore(div, typingIndicator);
        scrollToBottom();
    }

    function showTyping(show) {
        if (show) {
            typingIndicator.classList.remove('hidden');
            typingIndicator.classList.add('flex');
        } else {
            typingIndicator.classList.add('hidden');
            typingIndicator.classList.remove('flex');
        }
    }

    // 7. Reset Conversation Memory
    window.resetChatHistory = async function() {
        if (confirm('آیا مایلید تاریخچه گفتگوی فعلی پاک شود؟')) {
            try {
                await fetch('/api/chat/reset', { method: 'POST' });
                // Reset UI
                const userMessages = messagesBox.querySelectorAll('.mr-auto');
                userMessages.forEach(el => el.remove());
                const botResponses = messagesBox.querySelectorAll('.max-w-\\[90\\%\\]:not(:first-child)');
                botResponses.forEach(el => el.remove());
                const chips = document.getElementById('chat-suggestion-chips');
                if (chips) chips.classList.remove('hidden');

                // Reset Counter & Input View
                const formEl = document.getElementById('chat-form');
                const limitBox = document.getElementById('chat-limit-container');
                const badgeEl = document.getElementById('chat-counter-badge');
                if (formEl) formEl.classList.remove('hidden');
                if (limitBox) limitBox.classList.add('hidden');
                if (badgeEl) {
                    badgeEl.className = 'text-[10px] bg-white/20 text-blue-100 px-2 py-0.5 rounded-full font-medium';
                    badgeEl.innerHTML = '<span id="chat-messages-left">۶</span> پیام باقی‌مانده';
                }

                appendBotMessage('تاریخچه پاکسازی شد! چطور می‌توانم در زمینه سئو یا خدمات سایت کمکتان کنم؟');
            } catch (e) {
                console.error(e);
            }
        }
    };
})();
</script>
