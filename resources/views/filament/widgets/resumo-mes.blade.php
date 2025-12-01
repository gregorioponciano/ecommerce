<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Resumo do Mês
        </x-slot>

        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Produtos este mês</p>
                    <p class="text-2xl font-bold">{{ $this->getViewData()['produtosEsteMes'] }}</p>
                    <p class="text-sm {{ $this->getViewData()['variacao'] >= 0 ? 'text-success-600' : 'text-danger-600' }}">
                        {{ number_format(abs($this->getViewData()['variacao']), 1) }}% 
                        {{ $this->getViewData()['variacao'] >= 0 ? '↗ aumento' : '↘ redução' }}
                    </p>
                </div>
                
                <div>
                    <p class="text-sm font-medium text-gray-500">Média de Preços</p>
                    <p class="text-2xl font-bold">R$ {{ number_format($this->getViewData()['mediaPrecos'], 2, ',', '.') }}</p>
                </div>
            </div>

            @if($this->getViewData()['produtoMaisCaro'])
            <div class="border-t pt-4">
                <p class="text-sm font-medium text-gray-500">Produto Mais Caro</p>
                <p class="font-semibold">{{ $this->getViewData()['produtoMaisCaro']->nome }}</p>
                <p class="text-success-600 font-bold">R$ {{ number_format($this->getViewData()['produtoMaisCaro']->preco, 2, ',', '.') }}</p>
            </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>