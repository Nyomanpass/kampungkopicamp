<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class Settings extends Component
{
    use WithFileUploads;

    public $activeTab = 'banners';

    // Banners
    public $banners = [];
    public $newBannerImages = [];

    // Contact Info
    public $contact_whatsapp = '';
    public $contact_email = '';
    public $contact_phone = '';
    public $contact_address = '';

    // Google Maps
    public $google_maps_embed_url = '';

    // Social Media
    public $social_facebook = '';
    public $social_instagram = '';
    public $social_tiktok = '';
    public $social_youtube = '';

    // FAQs
    public $faqs = [];
    public $editingFaq = null;
    public $faqForm = [
        'question' => '',
        'answer' => '',
    ];

    // House Rules
    public $houseRules = [];
    public $editingRule = null;
    public $ruleForm = [
        'title' => '',
        'content' => '',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // Load Banners
        $bannersData = SiteSetting::where('key', 'banners')->first();
        $this->banners = $bannersData ? $bannersData->value : [];

        // Load Contact Info
        $contactData = SiteSetting::where('key', 'contact_info')->first();
        if ($contactData) {
            $contact = $contactData->value;
            $this->contact_whatsapp = $contact['whatsapp'] ?? '';
            $this->contact_email = $contact['email'] ?? '';
            $this->contact_phone = $contact['phone'] ?? '';
            $this->contact_address = $contact['address'] ?? '';
        }

        // Load Google Maps
        $mapsData = SiteSetting::where('key', 'google_maps')->first();
        if ($mapsData) {
            $this->google_maps_embed_url = $mapsData->value['embed_url'] ?? '';
        }

        // Load Social Media
        $socialData = SiteSetting::where('key', 'social_media')->first();
        if ($socialData) {
            $social = $socialData->value;
            $this->social_facebook = $social['facebook'] ?? '';
            $this->social_instagram = $social['instagram'] ?? '';
            $this->social_tiktok = $social['tiktok'] ?? '';
            $this->social_youtube = $social['youtube'] ?? '';
        }

        // Load FAQs
        $faqsData = SiteSetting::where('key', 'faqs')->first();
        $this->faqs = $faqsData ? $faqsData->value : [];

        // Load House Rules
        $rulesData = SiteSetting::where('key', 'house_rules')->first();
        $this->houseRules = $rulesData ? $rulesData->value : [];
    }

    // ===== BANNERS METHODS =====
    public function uploadBanners()
    {
        $this->validate([
            'newBannerImages.*' => 'image|max:2048',
        ]);

        $uploadedBanners = [];
        foreach ($this->newBannerImages as $image) {
            $path = $image->store('banners', 'public');
            $uploadedBanners[] = [
                'id' => count($this->banners) + count($uploadedBanners) + 1,
                'image' => $path,
                'order' => count($this->banners) + count($uploadedBanners) + 1,
            ];
        }

        $this->banners = array_merge($this->banners, $uploadedBanners);

        SiteSetting::set('banners', $this->banners, 'Banner carousel untuk dashboard user');

        $this->newBannerImages = [];
        session()->flash('success', 'Banner berhasil ditambahkan!');
    }

    public function deleteBanner($id)
    {
        $banner = collect($this->banners)->firstWhere('id', $id);

        if ($banner && isset($banner['image'])) {
            Storage::disk('public')->delete($banner['image']);
        }

        $this->banners = collect($this->banners)
            ->reject(fn($b) => $b['id'] == $id)
            ->values()
            ->toArray();

        SiteSetting::set('banners', $this->banners);
        session()->flash('success', 'Banner berhasil dihapus!');
    }

    // ===== CONTACT INFO METHODS =====
    public function saveContactInfo()
    {
        $this->validate([
            'contact_whatsapp' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_address' => 'required|string|max:500',
        ]);

        $contactData = [
            'whatsapp' => $this->contact_whatsapp,
            'email' => $this->contact_email,
            'phone' => $this->contact_phone,
            'address' => $this->contact_address,
        ];

        SiteSetting::set('contact_info', $contactData, 'Informasi kontak website');
        session()->flash('success', 'Informasi kontak berhasil disimpan!');
    }

    // ===== GOOGLE MAPS METHODS =====
    public function saveGoogleMaps()
    {
        $this->validate([
            'google_maps_embed_url' => 'required|url|max:1000',
        ]);

        SiteSetting::set('google_maps', [
            'embed_url' => $this->google_maps_embed_url,
        ], 'Google Maps embed link untuk lokasi');

        session()->flash('success', 'Google Maps berhasil disimpan!');
    }

    // ===== SOCIAL MEDIA METHODS =====
    public function saveSocialMedia()
    {
        $this->validate([
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_tiktok' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
        ]);

        $socialData = [
            'facebook' => $this->social_facebook,
            'instagram' => $this->social_instagram,
            'tiktok' => $this->social_tiktok,
            'youtube' => $this->social_youtube,
        ];

        SiteSetting::set('social_media', $socialData, 'Link media sosial');
        session()->flash('success', 'Link media sosial berhasil disimpan!');
    }

    // ===== FAQ METHODS =====
    public function addFaq()
    {
        $this->validate([
            'faqForm.question' => 'required|string|max:500',
            'faqForm.answer' => 'required|string|max:2000',
        ]);

        $newId = count($this->faqs) > 0 ? max(array_column($this->faqs, 'id')) + 1 : 1;

        $this->faqs[] = [
            'id' => $newId,
            'question' => $this->faqForm['question'],
            'answer' => $this->faqForm['answer'],
            'order' => count($this->faqs) + 1,
        ];

        SiteSetting::set('faqs', $this->faqs, 'Frequently Asked Questions');

        $this->resetFaqForm();
        session()->flash('success', 'FAQ berhasil ditambahkan!');
    }

    public function editFaq($id)
    {
        $faq = collect($this->faqs)->firstWhere('id', $id);
        if ($faq) {
            $this->editingFaq = $id;
            $this->faqForm = [
                'question' => $faq['question'],
                'answer' => $faq['answer'],
            ];
        }
    }

    public function updateFaq()
    {
        $this->validate([
            'faqForm.question' => 'required|string|max:500',
            'faqForm.answer' => 'required|string|max:2000',
        ]);

        $this->faqs = collect($this->faqs)->map(function ($faq) {
            if ($faq['id'] == $this->editingFaq) {
                $faq['question'] = $this->faqForm['question'];
                $faq['answer'] = $this->faqForm['answer'];
            }
            return $faq;
        })->toArray();

        SiteSetting::set('faqs', $this->faqs);

        $this->resetFaqForm();
        session()->flash('success', 'FAQ berhasil diperbarui!');
    }

    public function deleteFaq($id)
    {
        $this->faqs = collect($this->faqs)
            ->reject(fn($f) => $f['id'] == $id)
            ->values()
            ->toArray();

        SiteSetting::set('faqs', $this->faqs);
        session()->flash('success', 'FAQ berhasil dihapus!');
    }

    public function resetFaqForm()
    {
        $this->editingFaq = null;
        $this->faqForm = ['question' => '', 'answer' => ''];
        $this->resetValidation(['faqForm.question', 'faqForm.answer']);
    }

    // ===== HOUSE RULES METHODS =====
    public function addRule()
    {
        $this->validate([
            'ruleForm.title' => 'required|string|max:255',
            'ruleForm.content' => 'required|string|max:2000',
        ]);

        $newId = count($this->houseRules) > 0 ? max(array_column($this->houseRules, 'id')) + 1 : 1;

        $this->houseRules[] = [
            'id' => $newId,
            'title' => $this->ruleForm['title'],
            'content' => $this->ruleForm['content'],
            'order' => count($this->houseRules) + 1,
        ];

        SiteSetting::set('house_rules', $this->houseRules, 'Peraturan dan kebijakan tempat');

        $this->resetRuleForm();
        session()->flash('success', 'Peraturan berhasil ditambahkan!');
    }

    public function editRule($id)
    {
        $rule = collect($this->houseRules)->firstWhere('id', $id);
        if ($rule) {
            $this->editingRule = $id;
            $this->ruleForm = [
                'title' => $rule['title'],
                'content' => $rule['content'],
            ];
        }
    }

    public function updateRule()
    {
        $this->validate([
            'ruleForm.title' => 'required|string|max:255',
            'ruleForm.content' => 'required|string|max:2000',
        ]);

        $this->houseRules = collect($this->houseRules)->map(function ($rule) {
            if ($rule['id'] == $this->editingRule) {
                $rule['title'] = $this->ruleForm['title'];
                $rule['content'] = $this->ruleForm['content'];
            }
            return $rule;
        })->toArray();

        SiteSetting::set('house_rules', $this->houseRules);

        $this->resetRuleForm();
        session()->flash('success', 'Peraturan berhasil diperbarui!');
    }

    public function deleteRule($id)
    {
        $this->houseRules = collect($this->houseRules)
            ->reject(fn($r) => $r['id'] == $id)
            ->values()
            ->toArray();

        SiteSetting::set('house_rules', $this->houseRules);
        session()->flash('success', 'Peraturan berhasil dihapus!');
    }

    public function resetRuleForm()
    {
        $this->editingRule = null;
        $this->ruleForm = ['title' => '', 'content' => ''];
        $this->resetValidation(['ruleForm.title', 'ruleForm.content']);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.settings');
    }
}
