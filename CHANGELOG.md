# Changelog

Todas as mudanças notáveis neste projeto estão documentadas aqui.

## [2.5.1] - 2026-06-04

### Alterado
- **Mobile carousel threshold**: no mobile (≤ 768px) o carrossel agora é ativado com 5 ou mais cards (antes exigia 6+)
- Com exatamente 5 cards: grid fixo no desktop + carrossel no mobile
- Com 6+ cards: carrossel em todos os dispositivos (comportamento anterior mantido)
- CSS escopado com `.gdc-mobile-only-carousel` e `.gdc-desktop-only-grid` para alternância sem duplicação visual
- JS não inicializa o carrossel no desktop quando o modo é mobile-only

## [2.5.0] - 2026-05-30

### Adicionado
- Suporte a posts automáticos via WP_Query com filtro por taxonomia
- Border-radius configurável para badges, botões e setas
- Cor do texto configurável para todos os badges de tipo
- Opção de remover fundo das setas
- Opção de remover botão "Saiba mais"
- Texto personalizado para badge e modalidade nos posts automáticos
- Efeito hover scale (apenas desktop)
- Efeito hover escurecer cards não selecionados
- Swipe touch nativo para mobile
- Cor do título do card configurável
- Peso de fonte individual por elemento
- Alinhamento horizontal independente por elemento
- Posição vertical do botão "Saiba mais"
- Padding interno da seção configurável
- Opção de sem badge por card
- Opção de badge personalizado por card

## [2.4.0]
### Adicionado
- Cores de texto dos botões configuráveis
- Sliders de tamanho de fonte individuais
- Título do grid configurável

## [2.3.0]
### Adicionado
- Cores separadas por modalidade (EAD, Semipresencial, Presencial)
- Controle do sombreado com 4 pontos de opacidade
- Setas retangulares com cores configuráveis

## [2.2.0]
### Adicionado
- Painel completo de cores no admin com preview ao vivo

## [2.1.0]
### Adicionado
- Opção de tamanho de fonte base
- Fix fundo cinza herdado do tema

## [2.0.0]
### Adicionado
- Versão inicial com carrossel e grid
- ResizeObserver para inicialização correta
- CSS 100% escopado por ID

---

Desenvolvido por **Vausnicler Furin** — [vausnicler.dev](https://vausnicler.dev/)
