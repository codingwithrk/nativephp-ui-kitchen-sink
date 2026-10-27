<?php

use App\NativeComponents\Components\Examples\AccordionExample;
use App\NativeComponents\Components\Examples\AttachmentExample;
use App\NativeComponents\Components\Examples\ButtonExample;
use App\NativeComponents\Components\Examples\CardExample;
use App\NativeComponents\Components\Examples\CheckboxExample;
use App\NativeComponents\Components\Examples\DialogExample;
use App\NativeComponents\Components\Examples\FieldExample;
use App\NativeComponents\Components\Examples\InputOtpExample;
use App\NativeComponents\Components\Examples\MessageExample;
use App\NativeComponents\Components\Examples\PaginationExample;
use App\NativeComponents\Components\Examples\ProgressExample;
use App\NativeComponents\Components\Examples\RadioGroupExample;
use App\NativeComponents\Components\Examples\SidebarExample;
use App\NativeComponents\Components\Examples\SwitchExample;
use App\NativeComponents\Components\Examples\TabsExample;
use App\NativeComponents\Components\Examples\ToasterExample;
use App\NativeComponents\Components\Examples\ToggleExample;
use App\NativeComponents\Components\Examples\ToggleGroupExample;
use App\NativeComponents\Components\SidebarDemo;
use App\NativeComponents\Home;
use App\Showcase\Catalog;
use App\Showcase\DocsVersion;
use Native\Mobile\Testing\Native;

it('renders the example page for every component the installed plugin has', function () {
    foreach (Catalog::components() as $component) {
        Native::test($component->screen())
            ->assertSee($component->name)
            ->assertSee($component->description)
            ->assertSee('ui:'.$component->tags[0]);
    }
});

it('explains what changed in an updated component', function () {
    Native::test(ButtonExample::class)
        ->assertSee('Updated in 1.1.0')
        ->assertSee('buttons square off the corners');

    DocsVersion::view('1.0.1');

    Native::test(ButtonExample::class)
        ->assertDontSee('Updated in 1.1.0');
});

it('links to the other components in the same group', function () {
    Native::test(ButtonExample::class)
        ->assertSee('More in Actions')
        ->assertSee('Toggle');
});

it('shows a loading button while saving and finishes on poll', function () {
    $screen = Native::test(ButtonExample::class)
        ->tap('save')
        ->assertSet('isSaving', true)
        ->assertSee('Saving…');

    $screen->set('savingStartedAt', microtime(true) - 2);
    $screen->call('finishSaving')->assertSet('isSaving', false)->assertSee('Save changes');
});

it('toggles and controls toggles', function () {
    Native::test(ToggleExample::class)
        ->tap('bold')->assertSet('isBold', false)
        ->tap('italic')->assertSet('isItalic', true)
        ->tap('star')->assertSet('isStarred', true)
        ->assertSee('Starred');
});

it('selects values in toggle groups', function () {
    Native::test(ToggleGroupExample::class)
        ->tap('align-right')->assertSet('alignment', 'right')
        ->tap('style-italic')->assertSet('styles', ['bold', 'italic'])
        ->tap('range-month')->assertSet('range', 'month');
});

it('validates the email field live', function () {
    Native::test(FieldExample::class)
        ->assertSee('Please enter a valid email address.')
        ->input('email', 'rk@codingwithrk.com')
        ->assertDontSee('Please enter a valid email address.');
});

it('binds switches, checkboxes and radio groups', function () {
    Native::test(SwitchExample::class)
        ->tap('airplane')->assertSet('isAirplaneMode', true)
        ->tap('wifi')->assertSet('isWifiEnabled', false);

    Native::test(CheckboxExample::class)
        ->tap('terms')->assertSet('hasAcceptedTerms', true);

    Native::test(RadioGroupExample::class)
        ->tap('plan-free')->assertSet('plan', 'free')
        ->tap('shipping-standard')->assertSet('shipping', 'standard');
});

it('drives the create project card', function () {
    Native::test(CardExample::class)
        ->input('project-name', 'Acme')
        ->tap('deploy')->assertSet('isDeploying', true)
        ->tap('cancel')->assertSet('projectName', '')->assertSet('isDeploying', false);
});

it('advances and wraps the upload progress', function () {
    Native::test(ProgressExample::class)
        ->assertSee('13%')
        ->call('advance')->assertSet('percent', 22)
        ->set('percent', 100)
        ->call('advance')->assertSet('percent', 0);
});

it('switches tab panels', function () {
    Native::test(TabsExample::class)
        ->assertSee('Make changes to your account here.')
        ->tap('tab-password')
        ->assertSet('tab', 'password')
        ->assertSee('Change your password here.')
        ->assertDontSee('Make changes to your account here.');
});

it('opens and closes accordion items', function () {
    Native::test(AccordionExample::class)
        ->assertSee('Yes, on all orders over $50.')
        ->tap('faq-returns')
        ->assertSee('You can return any item within 30 days.')
        ->assertDontSee('Yes, on all orders over $50.')
        ->tap('section-privacy')
        ->assertSet('openSections', ['notifications']);
});

it('presents the dialog and sheet as bottom sheets', function () {
    Native::test(DialogExample::class)
        ->tap('open-delete')->assertSet('isConfirmingDelete', true)
        ->tap('cancel-delete')->assertSet('isConfirmingDelete', false)
        ->tap('open-filters')->assertSet('isFiltersOpen', true)
        ->dismissSheet('filters-sheet')->assertSet('isFiltersOpen', false);
});

it('leaves out the dialog trigger example on plugins without it', function () {
    $screen = Native::test(DialogExample::class);

    Catalog::component('dialog')->hasTag('dialog-trigger')
        ? $screen->assertSee('Trigger and close parts')
        : $screen->assertDontSee('Trigger and close parts');
});

describe('nativephp-ui 1.1.0 components', function () {
    it('shows toasts from the toaster example', function () {
        Native::test(ToasterExample::class)
            ->tap('toast-success')
            ->assertSee('Your changes were saved.')
            ->tap('toast-destructive')
            ->assertSee('Upload failed');
    });

    it('floats toasts over the screen instead of scrolling with the content', function (string $screen, array $taps, string $message) {
        $test = Native::test($screen);

        foreach ($taps as $ref) {
            $test->tap($ref);
        }

        $toaster = null;
        $find = function (array $node, bool $insideScroll) use (&$find, &$toaster, $message): void {
            $insideScroll = $insideScroll || ($node['type'] ?? null) === 'scroll_view';

            if (($node['layout']['position_type'] ?? null) === 1 && str_contains(json_encode($node), $message)) {
                $toaster = ['insideScroll' => $insideScroll];
            }

            foreach ($node['children'] ?? [] as $child) {
                $find($child, $insideScroll);
            }
        };
        $find($test->tree(), false);

        expect($toaster)->toBe(['insideScroll' => false]);
    })->with([
        'toaster page' => [ToasterExample::class, ['toast-success'], 'Your changes were saved.'],
        'page without a toaster tag' => [DialogExample::class, ['open-delete', 'confirm-delete'], 'Project deleted'],
    ]);

    it('opens the sidebar demo from the sidebar page', function () {
        Native::test(SidebarExample::class)
            ->assertSee('Open the sidebar demo')
            ->tap('open-sidebar-demo')
            ->assertNavigatedTo('/components/sidebar/demo');
    });

    it('puts the sidebar in a real native drawer whose items switch sections', function () {
        $demo = Native::test(SidebarDemo::class)
            ->assertSee('Your workspace at a glance.')
            ->assertElement('native_drawer', fn (array $drawer): bool => str_contains(json_encode($drawer), 'Acme Inc.'));

        $demo->tap('drawer-inbox')
            ->assertSet('section', 'inbox')
            ->assertSee('Can we move the review to Friday?')
            ->tap('drawer-billing')
            ->assertSee('Pro plan')
            ->tap('drawer-sign-out')
            ->assertSee('Signed out');
    });

    it('sends chat messages', function () {
        Native::test(MessageExample::class)
            ->input('draft', 'Hello')
            ->tap('send')
            ->assertSet('draft', '')
            ->assertSee('You said: Hello');
    });

    it('removes attachments', function () {
        Native::test(AttachmentExample::class)
            ->call('detach', 1)
            ->assertDontSee('Q3-report.pdf')
            ->assertSee('beach.jpg');
    });

    it('hides the typed digits behind the OTP boxes', function (string $screen) {
        $colors = [];
        $collect = function (array $node) use (&$collect, &$colors): void {
            if (($node['type'] ?? null) === 'bare_text_input' && isset($node['props']['max_length'])) {
                $colors[] = $node['props']['color'] ?? null;
            }

            foreach ($node['children'] ?? [] as $child) {
                $collect($child);
            }
        };
        $collect(Native::test($screen)->tree());

        // #AARRGGBB on the wire. It must be invisible (alpha at most 5/255)
        // but not 0: #00000000 reads as "no color" natively, so the digits
        // would show in the theme color.
        expect($colors)->not->toBeEmpty();

        foreach ($colors as $color) {
            expect($color)->toMatch('/^#[0-9a-f]{8}$/i')
                ->and(hexdec(substr($color, 1)))->toBeGreaterThan(0)
                ->and(hexdec(substr($color, 1, 2)))->toBeLessThanOrEqual(5);
        }
    })->with([
        'input otp page' => InputOtpExample::class,
        'home gallery' => Home::class,
    ]);

    it('shows a blinking caret in the next OTP box until the code is complete', function () {
        $carets = function (array $tree): int {
            $count = 0;
            $walk = function (array $node) use (&$walk, &$count): void {
                if (($node['props']['animate-loop'] ?? false) === true && (float) ($node['style']['opacity'] ?? 1) === 0.0) {
                    $count++;
                }

                foreach ($node['children'] ?? [] as $child) {
                    $walk($child);
                }
            };
            $walk($tree);

            return $count;
        };

        $screen = Native::test(InputOtpExample::class);
        expect($carets($screen->tree()))->toBe(3);

        $screen->input('code', '123');
        expect($carets($screen->tree()))->toBe(3);

        $screen->input('code', '123456');
        expect($carets($screen->tree()))->toBe(2);
    });

    it('changes pages', function () {
        Native::test(PaginationExample::class)
            ->call('goToPage', 7)
            ->assertSet('controlledPage', 7)
            ->assertSee('Page 7 of 20');
    });
})->skip(fn () => ! Catalog::supports('1.1.0'), 'Needs codingwithrk/nativephp-ui 1.1.0');
