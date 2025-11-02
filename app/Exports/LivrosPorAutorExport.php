<?php

namespace App\Exports;

use App\Models\RelatorioLivroAutor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LivrosPorAutorExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnFormatting
{
    protected $autorFiltro;

    public function __construct($autorFiltro = null)
    {
        $this->autorFiltro = $autorFiltro;
    }

    public function collection()
    {
        $query = RelatorioLivroAutor::orderBy('autor')->orderBy('titulo');

        if ($this->autorFiltro) {
            $query->where('codAu', $this->autorFiltro);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Autor',
            'Título do Livro',
            'Editora',
            'Edição',
            'Ano Publicação',
            'Valor (R$)',
            'Assuntos',
            'Data Cadastro'
        ];
    }

    public function map($livro): array
    {
        return [
            $livro->autor,
            $livro->titulo,
            $livro->editora,
            $livro->edicao . 'ª Edição',
            $livro->anoPublicacao,
            'R$ ' . number_format($livro->valor, 2, ',', '.'),
            $livro->assuntos,
            $livro->dataCadastro->format('d/m/Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3498DB'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Auto size para as colunas
        foreach(range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Estilo para os dados
        $sheet->getStyle('A2:H' . ($sheet->getHighestRow()))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        return [];
    }

    public function title(): string
    {
        return 'Livros por Autor';
    }

    public function columnFormats(): array
    {
        return [

        ];
    }
}
