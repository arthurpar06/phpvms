<x-filament-panels::page>
  @if (method_exists($this, 'filtersForm'))
    {{ $this->filtersForm }}
  @endif

  <x-filament-widgets::widgets
        :columns="$this->getColumns()"
        :data="
            [
                ...(property_exists($this, 'filters') ? ['filters' => $this->filters] : []),
                ...$this->getWidgetData(),
            ]
        "
        :widgets="$this->getWidgets()"
    />

</x-filament-panels::page>
