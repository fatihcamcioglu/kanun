/**
 * Helper utility functions
 */

export const formatDate = (date: Date | string): string => {
  const d = typeof date === 'string' ? new Date(date) : date;
  const now = new Date();
  const diff = now.getTime() - d.getTime();
  const days = Math.floor(diff / (1000 * 60 * 60 * 24));

  if (days === 0) {
    return 'Bugün';
  } else if (days === 1) {
    return 'Dün';
  } else if (days < 7) {
    return `${days} gün önce`;
  } else if (days < 30) {
    const weeks = Math.floor(days / 7);
    return `${weeks} hafta önce`;
  } else if (days < 365) {
    const months = Math.floor(days / 30);
    return `${months} ay önce`;
  } else {
    const years = Math.floor(days / 365);
    return `${years} yıl önce`;
  }
};

export const formatPhoneNumber = (phone: string): string => {
  // Format Turkish phone number: 5XX XXX XX XX
  const cleaned = phone.replace(/\D/g, '');
  if (cleaned.length === 10) {
    return cleaned.replace(/(\d{3})(\d{3})(\d{2})(\d{2})/, '$1 $2 $3 $4');
  }
  return phone;
};

export const validateEmail = (email: string): boolean => {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
};

export const validatePhone = (phone: string): boolean => {
  const cleaned = phone.replace(/\D/g, '');
  return cleaned.length === 10 || cleaned.length === 11;
};

export const formatFileSize = (bytes: number): string => {
  if (bytes === 0) return '0 Bytes';
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
};

