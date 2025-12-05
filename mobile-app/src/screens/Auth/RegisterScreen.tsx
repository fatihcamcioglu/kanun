import React, {useState} from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  KeyboardAvoidingView,
  Platform,
  TouchableOpacity,
  SafeAreaView,
} from 'react-native';
import {Header} from '@components/Header';
import {Input} from '@components/Input';
import {Button} from '@components/Button';
import {theme} from '@theme';

interface RegisterScreenProps {
  navigation: any;
}

export const RegisterScreen: React.FC<RegisterScreenProps> = ({navigation}) => {
  const [formData, setFormData] = useState({
    fullName: '',
    email: '',
    phone: '',
    password: '',
    confirmPassword: '',
  });
  const [agreements, setAgreements] = useState({
    kvkk: false,
    terms: false,
  });
  const [loading, setLoading] = useState(false);

  const handleRegister = async () => {
    setLoading(true);
    // TODO: Implement register logic
    setTimeout(() => {
      setLoading(false);
      navigation.replace('Login');
    }, 1000);
  };

  const toggleAgreement = (key: 'kvkk' | 'terms') => {
    setAgreements(prev => ({...prev, [key]: !prev[key]}));
  };

  return (
    <SafeAreaView style={styles.container}>
      <KeyboardAvoidingView
        behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
        style={styles.keyboardView}>
        <Header
          showLogo
          showBack
          onBackPress={() => navigation.goBack()}
          backgroundColor={theme.colors.background}
        />
        <ScrollView
          contentContainerStyle={styles.scrollContent}
          keyboardShouldPersistTaps="handled">
          <View style={styles.content}>
            <Text style={styles.title}>Kayıt Ol</Text>
            <Text style={styles.subtitle}>
              Türk Hukukunu Dünya'ya Taşıyoruz!
            </Text>

            <View style={styles.form}>
              <Input
                placeholder="Ad Soyad"
                value={formData.fullName}
                onChangeText={text => setFormData({...formData, fullName: text})}
              />
              <Input
                placeholder="E-posta"
                value={formData.email}
                onChangeText={text => setFormData({...formData, email: text})}
                keyboardType="email-address"
                autoCapitalize="none"
                autoCorrect={false}
              />
              <View style={styles.phoneContainer}>
                <View style={styles.countryCode}>
                  <Text style={styles.countryCodeText}>🇹🇷 (+90)</Text>
                </View>
                <View style={styles.phoneInput}>
                  <Input
                    placeholder="Telefon Numarası"
                    value={formData.phone}
                    onChangeText={text => setFormData({...formData, phone: text})}
                    keyboardType="phone-pad"
                  />
                </View>
              </View>
              <Input
                placeholder="Şifre"
                value={formData.password}
                onChangeText={text => setFormData({...formData, password: text})}
                secureTextEntry
                showPasswordToggle
              />
              <Input
                placeholder="Şifre Doğrulama"
                value={formData.confirmPassword}
                onChangeText={text =>
                  setFormData({...formData, confirmPassword: text})
                }
                secureTextEntry
                showPasswordToggle
              />

              <View style={styles.agreements}>
                <TouchableOpacity
                  style={styles.checkboxContainer}
                  onPress={() => toggleAgreement('kvkk')}>
                  <View
                    style={[
                      styles.checkbox,
                      agreements.kvkk && styles.checkboxChecked,
                    ]}>
                    {agreements.kvkk && (
                      <Text style={styles.checkmark}>✓</Text>
                    )}
                  </View>
                  <Text style={styles.checkboxLabel}>
                    KVKK Sözleşmesini okudum ve kabul ediyorum.
                  </Text>
                </TouchableOpacity>
                <TouchableOpacity
                  style={styles.checkboxContainer}
                  onPress={() => toggleAgreement('terms')}>
                  <View
                    style={[
                      styles.checkbox,
                      agreements.terms && styles.checkboxChecked,
                    ]}>
                    {agreements.terms && (
                      <Text style={styles.checkmark}>✓</Text>
                    )}
                  </View>
                  <Text style={styles.checkboxLabel}>
                    Kullanım şartlarını okudum ve anladım.
                  </Text>
                </TouchableOpacity>
              </View>

              <Button
                title="Kayıt Ol"
                onPress={handleRegister}
                loading={loading}
                fullWidth
                variant="primary"
                disabled={!agreements.kvkk || !agreements.terms}
              />
            </View>
          </View>

          <View style={styles.footer}>
            <Text style={styles.footerText}>Zaten bir hesabınız var mı? </Text>
            <TouchableOpacity onPress={() => navigation.navigate('Login')}>
              <Text style={styles.footerLink}>Giriş Yap</Text>
            </TouchableOpacity>
          </View>
        </ScrollView>
      </KeyboardAvoidingView>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: theme.colors.background,
  },
  keyboardView: {
    flex: 1,
  },
  scrollContent: {
    flexGrow: 1,
    paddingBottom: theme.spacing.xl,
  },
  content: {
    flex: 1,
    padding: theme.spacing.lg,
  },
  title: {
    ...theme.typography.h1,
    marginBottom: theme.spacing.sm,
  },
  subtitle: {
    ...theme.typography.subtitle,
    marginBottom: theme.spacing.xl,
  },
  form: {
    marginTop: theme.spacing.lg,
  },
  phoneContainer: {
    flexDirection: 'row',
    marginBottom: theme.spacing.md,
  },
  countryCode: {
    width: 100,
    marginRight: theme.spacing.sm,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: theme.colors.input.background,
    borderRadius: theme.borderRadius.sm,
    borderWidth: 1,
    borderColor: theme.colors.input.border,
  },
  countryCodeText: {
    ...theme.typography.input,
  },
  phoneInput: {
    flex: 1,
  },
  agreements: {
    marginVertical: theme.spacing.lg,
  },
  checkboxContainer: {
    flexDirection: 'row',
    alignItems: 'flex-start',
    marginBottom: theme.spacing.md,
  },
  checkbox: {
    width: 24,
    height: 24,
    borderRadius: 4,
    borderWidth: 2,
    borderColor: theme.colors.accent,
    marginRight: theme.spacing.sm,
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: theme.colors.background,
  },
  checkboxChecked: {
    backgroundColor: theme.colors.accent,
  },
  checkmark: {
    color: theme.colors.text.inverse,
    fontSize: 16,
    fontWeight: 'bold',
  },
  checkboxLabel: {
    ...theme.typography.bodySmall,
    flex: 1,
    color: theme.colors.text.primary,
  },
  footer: {
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    paddingHorizontal: theme.spacing.lg,
    paddingVertical: theme.spacing.md,
  },
  footerText: {
    ...theme.typography.body,
    color: theme.colors.text.secondary,
  },
  footerLink: {
    ...theme.typography.link,
    fontSize: 16,
  },
});

