export function money(value: number | string | null | undefined): string {
  const amount = Number(value ?? 0)

  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    maximumFractionDigits: 2,
  }).format(amount)
}

export function dateLabel(value?: string): string {
  if (!value) {
    return 'Recently'
  }

  return new Intl.DateTimeFormat('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
  }).format(new Date(value))
}

export function productPrice(value: number | string): number {
  return Number(value)
}

export function discountedPrice(
  price: number | string,
  discountPrice?: number | string | null,
): number {
  return Number(discountPrice ?? price)
}

export function percentOff(price: number | string, discountPrice?: number | string | null): number {
  const base = Number(price)
  const discount = Number(discountPrice ?? price)

  if (!base || discount >= base) {
    return 0
  }

  return Math.round(((base - discount) / base) * 100)
}
