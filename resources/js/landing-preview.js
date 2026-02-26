export default function registerLandingPreview(Alpine) {
    Alpine.data('landingPreview', (initial = {}) => ({
        preview: {
            homeUrl: initial.homeUrl ?? '',
            dashboardUrl: initial.dashboardUrl ?? '',
            loginUrl: initial.loginUrl ?? '',
            registerUrl: initial.registerUrl ?? '',
            isAuthenticated: Boolean(initial.isAuthenticated ?? false),
            canRegister: Boolean(initial.canRegister ?? false),
            storageBaseUrl: initial.storageBaseUrl ?? '',
            locale: initial.locale ?? 'en',
            appName: initial.appName ?? 'Laravel',
            slug: initial.slug ?? '',
            statusId: Number(initial.statusId ?? 0),
            heroTitle: initial.heroTitle ?? '',
            heroSubtitle: initial.heroSubtitle ?? '',
            heroPrimaryText: initial.heroPrimaryText ?? '',
            heroPrimaryUrl: initial.heroPrimaryUrl ?? '',
            heroSecondaryText: initial.heroSecondaryText ?? '',
            heroSecondaryUrl: initial.heroSecondaryUrl ?? '',
            bannerTitle: initial.bannerTitle ?? '',
            bannerSubtitle: initial.bannerSubtitle ?? '',
            bannerImagePath: initial.bannerImagePath ?? '',
            bannerImageUrl: '',
            bannerAlt: initial.bannerAlt ?? '',
            aboutTitle: initial.aboutTitle ?? '',
            aboutBody: initial.aboutBody ?? '',
            aboutImagePath: initial.aboutImagePath ?? '',
            aboutImageUrl: '',
            aboutAlt: initial.aboutAlt ?? '',
            securityTitle: initial.securityTitle ?? '',
            securityBody: initial.securityBody ?? '',
            securityImagePath: initial.securityImagePath ?? '',
            securityImageUrl: '',
            securityAlt: initial.securityAlt ?? '',
            footerText: initial.footerText ?? '',
            articlePreviews: initial.articlePreviews ?? {},
            articleOptions: initial.articleOptions ?? {},
            articles: Array.isArray(initial.articles) ? initial.articles : [],
            features: Array.isArray(initial.features) ? initial.features : [],
        },
        filePreviewCache: {},
        syncFrameId: null,

        init(form) {
            if (!(form instanceof HTMLFormElement)) {
                this.refreshImages(null);

                return;
            }

            this.syncFromForm(form);
            form.addEventListener('input', () => {
                this.scheduleSync(form);
            });
            form.addEventListener('change', () => {
                this.scheduleSync(form);
            });
        },

        scheduleSync(form) {
            if (!(form instanceof HTMLFormElement)) {
                this.refreshImages(null);

                return;
            }

            if (typeof window.requestAnimationFrame !== 'function') {
                this.syncFromForm(form);

                return;
            }

            if (this.syncFrameId !== null) {
                window.cancelAnimationFrame(this.syncFrameId);
            }

            this.syncFrameId = window.requestAnimationFrame(() => {
                this.syncFrameId = null;
                this.syncFromForm(form);
            });
        },

        syncFromForm(form) {
            if (!(form instanceof HTMLFormElement)) {
                this.refreshImages(null);

                return;
            }

            this.preview.slug = this.formValue(form, 'slug', this.preview.slug);
            this.preview.statusId = Number(
                this.formValue(form, 'status_id', String(this.preview.statusId || 0))
            );
            this.preview.heroTitle = this.localizedInputValue(
                form,
                'content[hero][title]',
                this.preview.heroTitle
            );
            this.preview.heroSubtitle = this.localizedInputValue(
                form,
                'content[hero][subtitle]',
                this.preview.heroSubtitle
            );
            this.preview.heroPrimaryText = this.localizedInputValue(
                form,
                'content[hero][primary_button][text]',
                this.preview.heroPrimaryText
            );
            this.preview.heroPrimaryUrl = this.formValue(
                form,
                'content[hero][primary_button][url]',
                this.preview.heroPrimaryUrl
            );
            this.preview.heroSecondaryText = this.localizedInputValue(
                form,
                'content[hero][secondary_button][text]',
                this.preview.heroSecondaryText
            );
            this.preview.heroSecondaryUrl = this.formValue(
                form,
                'content[hero][secondary_button][url]',
                this.preview.heroSecondaryUrl
            );
            this.preview.bannerTitle = this.localizedInputValue(
                form,
                'content[banner][title]',
                this.preview.bannerTitle
            );
            this.preview.bannerSubtitle = this.localizedInputValue(
                form,
                'content[banner][subtitle]',
                this.preview.bannerSubtitle
            );
            this.preview.bannerImagePath = this.formValue(
                form,
                'content[banner][image]',
                this.preview.bannerImagePath
            );
            this.preview.bannerAlt = this.localizedInputValue(
                form,
                'content[banner][alt]',
                this.preview.bannerAlt
            );
            this.preview.aboutTitle = this.localizedInputValue(
                form,
                'content[about][title]',
                this.preview.aboutTitle
            );
            this.preview.aboutBody = this.localizedInputValue(
                form,
                'content[about][body]',
                this.preview.aboutBody
            );
            this.preview.aboutImagePath = this.formValue(
                form,
                'content[about][image]',
                this.preview.aboutImagePath
            );
            this.preview.aboutAlt = this.localizedInputValue(
                form,
                'content[about][alt]',
                this.preview.aboutAlt
            );
            this.preview.securityTitle = this.localizedInputValue(
                form,
                'content[security][title]',
                this.preview.securityTitle
            );
            this.preview.securityBody = this.localizedInputValue(
                form,
                'content[security][body]',
                this.preview.securityBody
            );
            this.preview.securityImagePath = this.formValue(
                form,
                'content[security][image]',
                this.preview.securityImagePath
            );
            this.preview.securityAlt = this.localizedInputValue(
                form,
                'content[security][alt]',
                this.preview.securityAlt
            );
            this.preview.footerText = this.localizedInputValue(
                form,
                'content[footer][text]',
                this.preview.footerText
            );

            for (let index = 0; index < 3; index++) {
                if (!this.preview.articles[index]) {
                    this.preview.articles[index] = {
                        articleSlug: '',
                        title: '',
                        excerpt: '',
                        imagePath: '',
                        alt: '',
                        imageUrl: '',
                    };
                }

                this.preview.articles[index].articleSlug = this.formValue(
                    form,
                    `content[articles][${index}][article_slug]`,
                    this.preview.articles[index].articleSlug ?? ''
                );
                this.preview.articles[index].title = this.localizedInputValue(
                    form,
                    `content[articles][${index}][title]`,
                    this.preview.articles[index].title ?? ''
                );
                this.preview.articles[index].excerpt = this.localizedInputValue(
                    form,
                    `content[articles][${index}][excerpt]`,
                    this.preview.articles[index].excerpt ?? ''
                );
                this.preview.articles[index].imagePath = this.formValue(
                    form,
                    `content[articles][${index}][image]`,
                    this.preview.articles[index].imagePath ?? ''
                );
                this.preview.articles[index].alt = this.localizedInputValue(
                    form,
                    `content[articles][${index}][alt]`,
                    this.preview.articles[index].alt ?? ''
                );
            }

            for (let index = 0; index < 3; index++) {
                if (!this.preview.features[index]) {
                    this.preview.features[index] = {
                        icon: 'sparkles',
                        title: '',
                        description: '',
                    };
                }

                this.preview.features[index].icon = this.formValue(
                    form,
                    `content[features][${index}][icon]`,
                    this.preview.features[index].icon ?? 'sparkles'
                );
                this.preview.features[index].title = this.localizedInputValue(
                    form,
                    `content[features][${index}][title]`,
                    this.preview.features[index].title ?? ''
                );
                this.preview.features[index].description = this.localizedInputValue(
                    form,
                    `content[features][${index}][description]`,
                    this.preview.features[index].description ?? ''
                );
            }

            this.refreshImages(form);
        },

        formValue(form, name, fallback = '') {
            const field = form.querySelector(`[name="${name}"]`);

            if (!field) {
                return fallback ?? '';
            }

            if (field instanceof HTMLInputElement && field.type === 'file') {
                return fallback ?? '';
            }

            if (field instanceof HTMLInputElement && field.type === 'checkbox') {
                return field.checked ? field.value || '1' : '';
            }

            return typeof field.value === 'string' ? field.value : fallback ?? '';
        },

        localizedInputValue(form, baseName, fallback = '') {
            const activeLocale = this.activeLocale();
            const fallbackLocale = activeLocale === 'ms' ? 'en' : 'ms';
            const localizedName = `${baseName}[${activeLocale}]`;
            const fallbackName = `${baseName}[${fallbackLocale}]`;
            const localizedValue = this.formValue(form, localizedName, null);

            if (localizedValue !== null) {
                return localizedValue;
            }

            const legacyValue = this.formValue(form, baseName, null);

            if (legacyValue !== null) {
                return legacyValue;
            }

            const fallbackValue = this.formValue(form, fallbackName, null);

            if (fallbackValue !== null) {
                return fallbackValue;
            }

            return fallback ?? '';
        },

        activeLocale() {
            return this.preview.locale === 'ms' ? 'ms' : 'en';
        },

        refreshImages(form) {
            this.preview.bannerImageUrl = this.resolveImage(
                form,
                'content[banner][image]',
                this.preview.bannerImagePath
            );
            this.preview.aboutImageUrl = this.resolveImage(
                form,
                'content[about][image]',
                this.preview.aboutImagePath
            );
            this.preview.securityImageUrl = this.resolveImage(
                form,
                'content[security][image]',
                this.preview.securityImagePath
            );

            for (let index = 0; index < 3; index++) {
                const article = this.preview.articles[index] ?? {};
                article.imageUrl = this.resolveImage(
                    form,
                    `content[articles][${index}][image]`,
                    article.imagePath ?? ''
                );
                this.preview.articles[index] = article;
            }
        },

        resolveImage(form, inputName, currentPath) {
            const input = form instanceof HTMLFormElement
                ? form.querySelector(`[name="${inputName}"]`)
                : null;

            if (input instanceof HTMLInputElement && input.files && input.files.length > 0) {
                const file = input.files[0];

                if (this.filePreviewCache[inputName]) {
                    URL.revokeObjectURL(this.filePreviewCache[inputName]);
                }

                this.filePreviewCache[inputName] = URL.createObjectURL(file);

                return this.filePreviewCache[inputName];
            }

            return this.toStorageUrl(currentPath);
        },

        toStorageUrl(path) {
            if (!this.isFilled(path)) {
                return '';
            }

            if (
                path.startsWith('blob:') ||
                path.startsWith('http://') ||
                path.startsWith('https://') ||
                path.startsWith('/')
            ) {
                return path;
            }

            const base = (this.preview.storageBaseUrl ?? '').replace(/\/$/, '');
            const normalizedPath = path.replace(/^\/+/, '');

            return base ? `${base}/${normalizedPath}` : `/${normalizedPath}`;
        },

        isFilled(value) {
            return typeof value === 'string' ? value.trim() !== '' : Boolean(value);
        },

        hasBannerSection() {
            return (
                this.isFilled(this.preview.bannerTitle) ||
                this.isFilled(this.preview.bannerSubtitle) ||
                this.isFilled(this.preview.bannerImageUrl)
            );
        },

        hasAboutSection() {
            return (
                this.isFilled(this.preview.aboutTitle) ||
                this.isFilled(this.preview.aboutBody) ||
                this.isFilled(this.preview.aboutImageUrl)
            );
        },

        hasSecuritySection() {
            return (
                this.isFilled(this.preview.securityTitle) ||
                this.isFilled(this.preview.securityBody) ||
                this.isFilled(this.preview.securityImageUrl)
            );
        },

        hasFeatures() {
            return Array.isArray(this.preview.features) && this.preview.features.length > 0;
        },

        heroSecondaryTarget() {
            return this.isExternalUrl(this.preview.heroSecondaryUrl) ? '_blank' : '_self';
        },

        resolveArticle(article) {
            const data = typeof article === 'object' && article !== null ? article : {};
            const articleSlug = this.isFilled(data.articleSlug) ? String(data.articleSlug).trim() : '';
            const linkedArticle = articleSlug !== '' ? this.preview.articlePreviews?.[articleSlug] : null;
            const title = this.isFilled(data.title)
                ? data.title
                : (linkedArticle?.title ?? this.preview.articleOptions?.[articleSlug] ?? '');
            const excerpt = this.isFilled(data.excerpt) ? data.excerpt : (linkedArticle?.excerpt ?? '');
            const url = linkedArticle?.url ?? '';

            return {
                articleSlug,
                title,
                excerpt,
                imageUrl: data.imageUrl ?? '',
                alt: data.alt ?? '',
                url,
            };
        },

        visibleArticles() {
            return (this.preview.articles ?? [])
                .map((article) => this.resolveArticle(article))
                .filter((article) => this.isFilled(article.url));
        },

        articleTarget(url) {
            return this.isExternalUrl(url) ? '_blank' : '_self';
        },

        featureIconId(icon) {
            const featureIcons = {
                sparkles: 'feature-icon-sparkles',
                shield: 'feature-icon-shield',
                globe: 'feature-icon-globe',
                zap: 'feature-icon-zap',
                heart: 'feature-icon-heart',
                star: 'feature-icon-star',
                default: 'feature-icon-default',
            };
            const iconKey = this.isFilled(icon) ? String(icon).trim() : 'default';

            return featureIcons[iconKey] ?? featureIcons.default;
        },

        isExternalUrl(url) {
            return this.isFilled(url) && /^https?:\/\//i.test(String(url));
        },

        heroTitle() {
            if (this.isFilled(this.preview.heroTitle)) {
                return this.preview.heroTitle;
            }

            return this.preview.appName ?? 'Laravel';
        },

        heroPrimaryUrl() {
            return this.isFilled(this.preview.heroPrimaryUrl)
                ? this.preview.heroPrimaryUrl
                : (this.preview.loginUrl || '/login');
        },

        languageLabel() {
            return this.preview.locale === 'ms' ? 'Melayu' : 'English';
        },

        footerText() {
            return this.isFilled(this.preview.footerText)
                ? this.preview.footerText
                : 'Built with Laravel';
        },
    }));
}
