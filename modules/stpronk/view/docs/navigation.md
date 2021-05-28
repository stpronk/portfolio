# Navigation

---

### group & addItem

    Navigation::group(string $group)

    ->AddItem(string $title, string $icon, ?string $routeName, ?int $order = null, ?callable $submenu = null, ?array $options = [])
 
Options:
    
    [
        'hide-sub-menu'    => false,
        'track-sub-active' => false
    ]

Helpers:

    navigation(string $group)

Examples:

    Navigation::group('general')
        ->addItem('Dashboard', 'th', 'home', 0)
        ->addItem('Assignments','files-o', null, 1, function (Builder $b) {
            $b->addItem('Dealer', 'car', 'assignment.dealer', 0, null, ['project' => 1])
              ->addItem('Event planner', 'calendar', 'assignment.event-planner', 1);
        })
        ->addItem('Finance', 'money', 'finance.index', 2, null, ['track-sub-active' => true]);

    navigation('admin')
        ->addItem('settings', 'cog', 'settings', 0)

---

### generateMenu

    navigation::generateMenu(string $group, string $style, array $options = [])

Options:

    [
        'filters'           => [],
        'ignore-filters'    => false,
        'ignore-middleware' => false
    ]

Helpers:

    generateMenu(string $group, string $style, array $options = [])

Example:
    
    \Stpronk\View\Facades\Navigation::generateMenu('general', 'general', ['filters' => ['general']])

    generateMenu('admin', 'dropdown', ['filters' => ['auth', 'admin'], 'ignore-middleware' => true)

