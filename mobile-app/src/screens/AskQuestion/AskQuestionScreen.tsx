import React, {useState} from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  SafeAreaView,
  TouchableOpacity,
  TextInput,
  KeyboardAvoidingView,
  Platform,
} from 'react-native';
import { MaterialIcons } from '@expo/vector-icons';
import {Header} from '@components/Header';
import {Input} from '@components/Input';
import {theme} from '@theme';

interface AskQuestionScreenProps {
  navigation: any;
}

export const AskQuestionScreen: React.FC<AskQuestionScreenProps> = ({
  navigation,
}) => {
  const [category, setCategory] = useState('');
  const [title, setTitle] = useState('');
  const [question, setQuestion] = useState('');

  return (
    <SafeAreaView style={styles.container}>
      <KeyboardAvoidingView
        behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
        style={styles.keyboardView}>
        <Header
          title="Soru Sor"
          showBack
          onBackPress={() => navigation.goBack()}
          backgroundColor={theme.colors.primary}
        />
        <ScrollView
          style={styles.scrollView}
          contentContainerStyle={styles.scrollContent}>
          <View style={styles.content}>
            <TouchableOpacity style={styles.categorySelector}>
              <Text style={[styles.placeholder, category && styles.filled]}>
                {category || 'Kategori Seç'}
              </Text>
              <MaterialIcons
                name="keyboard-arrow-down"
                size={theme.iconSizes.md}
                color={theme.colors.text.tertiary}
              />
            </TouchableOpacity>

            <View style={styles.titleContainer}>
              <TextInput
                style={[styles.titleInput, title && styles.filled]}
                placeholder="Soru Başlığı"
                placeholderTextColor={theme.colors.input.placeholder}
                value={title}
                onChangeText={setTitle}
                maxLength={75}
              />
              <Text style={styles.characterCount}>{title.length}/75</Text>
            </View>

            <View style={styles.questionArea}>
              <TextInput
                style={styles.questionInput}
                placeholder="Sorunuzu buraya yazın..."
                placeholderTextColor={theme.colors.input.placeholder}
                value={question}
                onChangeText={setQuestion}
                multiline
                textAlignVertical="top"
              />
            </View>
          </View>
        </ScrollView>
        <View style={styles.bottomBar}>
          <TextInput
            style={styles.bottomInput}
            placeholder="Sorunuzu sorun.."
            placeholderTextColor={theme.colors.input.placeholder}
          />
          <TouchableOpacity style={styles.attachmentButton}>
            <MaterialIcons
              name="image"
              size={theme.iconSizes.md}
              color={theme.colors.text.tertiary}
            />
          </TouchableOpacity>
          <TouchableOpacity style={styles.attachmentButton}>
            <MaterialIcons
              name="insert-drive-file"
              size={theme.iconSizes.md}
              color={theme.colors.text.tertiary}
            />
          </TouchableOpacity>
          <TouchableOpacity style={styles.micButton}>
            <MaterialIcons
              name="mic"
              size={theme.iconSizes.lg}
              color={theme.colors.text.inverse}
            />
          </TouchableOpacity>
        </View>
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
  scrollView: {
    flex: 1,
  },
  scrollContent: {
    flexGrow: 1,
    padding: theme.spacing.md,
  },
  content: {
    flex: 1,
  },
  categorySelector: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingVertical: theme.spacing.md,
    borderBottomWidth: 1,
    borderBottomColor: theme.colors.border.light,
    marginBottom: theme.spacing.md,
  },
  placeholder: {
    ...theme.typography.inputPlaceholder,
  },
  filled: {
    ...theme.typography.input,
  },
  titleContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingVertical: theme.spacing.md,
    borderBottomWidth: 1,
    borderBottomColor: theme.colors.border.light,
    marginBottom: theme.spacing.md,
  },
  titleInput: {
    ...theme.typography.inputPlaceholder,
    flex: 1,
  },
  characterCount: {
    ...theme.typography.caption,
    color: theme.colors.text.tertiary,
  },
  questionArea: {
    flex: 1,
    marginTop: theme.spacing.md,
  },
  questionInput: {
    ...theme.typography.body,
    flex: 1,
    minHeight: 200,
  },
  bottomBar: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: theme.spacing.md,
    paddingVertical: theme.spacing.sm,
    backgroundColor: theme.colors.surface,
    borderTopWidth: 1,
    borderTopColor: theme.colors.border.light,
  },
  bottomInput: {
    ...theme.typography.input,
    flex: 1,
    backgroundColor: theme.colors.background,
    borderRadius: theme.borderRadius.sm,
    paddingHorizontal: theme.spacing.md,
    paddingVertical: theme.spacing.sm,
    marginRight: theme.spacing.sm,
  },
  attachmentButton: {
    padding: theme.spacing.sm,
    marginRight: theme.spacing.xs,
  },
  micButton: {
    width: 48,
    height: 48,
    borderRadius: 24,
    backgroundColor: theme.colors.primary,
    alignItems: 'center',
    justifyContent: 'center',
  },
});

